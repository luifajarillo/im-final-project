let qty = 1;
let currentItem = { category: '', id: '' };

function openModal(title, image, description, price, category, id) {
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalImage').src = image;
    document.getElementById('modalDesc').innerText = description || '';
    document.getElementById('modalPrice').innerText = price;
    document.getElementById('qtyValue').innerText = 1;

    const checklist = document.getElementById('checklist');
    checklist.innerHTML = '<p>Loading add-ons...</p>';

    fetch(`fetch_addons.php?category=${encodeURIComponent(category)}&id=${encodeURIComponent(id)}`)
        .then(res => res.json())
        .then(data => {
            checklist.innerHTML = '';
            if (!data.length) {
                checklist.innerHTML = '<p>No add-ons available.</p>';
                return;
            }
            data.forEach((addon, index) => {
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.id = 'addon' + index;
                checkbox.name = 'addons[]';
                checkbox.value = addon.name + (addon.price > 0 ? ` (₱${addon.price})` : ' (Free)');
                checkbox.dataset.price = addon.price;

                const label = document.createElement('label');
                label.htmlFor = checkbox.id;
                label.textContent = `Add ${addon.name}` + (addon.price > 0 ? ` (₱${addon.price})` : ' (Free)');

                const div = document.createElement('div');   
                div.appendChild(checkbox);
                div.appendChild(label);
                checklist.appendChild(div);
            });
        })
        .catch(() => {
            checklist.innerHTML = '<p>Failed to load add-ons.</p>';
        });

    document.getElementById('itemModal').style.display = 'flex';
}

function fetchAddons(category, id) {
    const checklist = document.getElementById('checklist');
    checklist.innerHTML = ''; // ✅ Fix: Clear previous add-ons

    checklist.innerHTML = '<p style="color: #888;">Loading add-ons...</p>';

    fetch(`get_addons.php?category=${category}&id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (!data.length) {
                checklist.innerHTML = '<p style="color: #888;">No available add-ons.</p>';
                return;
            }
            checklist.innerHTML = data.map(addon => `
                <div>
                    <input type="checkbox" id="${addon.addon_id}" data-price="${addon.price}" />
                    <label for="${addon.addon_id}">Add ${addon.name} (+₱${addon.price})</label>
                </div>`).join('');
        })
        .catch(() => {
            checklist.innerHTML = '<p style="color: red;">Failed to load add-ons.</p>';
        });
}


function closeModal() {
    document.getElementById('itemModal').style.display = 'none';
}

function changeQty(amount) {
    qty = Math.max(1, qty + amount);
    document.getElementById('qtyValue').innerText = qty;
}

const cartBtn = document.getElementById("cartBtn");
const cartModal = document.getElementById("cartModal");

if (cartBtn) {
    cartBtn.addEventListener("click", showCart);
}

function showCart() {
    cartModal.style.display = "flex";
}

function closeCart() {
    cartModal.style.display = "none";
}

window.addEventListener("click", (e) => {
    if (e.target === cartModal) {
        closeCart();
    }
});

const closeCartBtn = cartModal.querySelector(".close");
if (closeCartBtn) {
    closeCartBtn.addEventListener("click", closeCart);
}

function addToCart() {
    closeModal();

    const cartItems = document.getElementById('cartItems');
    const emptyText = cartItems.querySelector('p');
    if (emptyText) emptyText.remove();

    const name = document.getElementById('modalTitle').innerText;
    const price = parseFloat(document.getElementById('modalPrice').innerText);
    const quantity = parseInt(document.getElementById('qtyValue').innerText);
    const image = document.getElementById('modalImage').src;

    const selectedAddons = Array.from(document.querySelectorAll('#checklist input:checked'));
    const addonNames = selectedAddons.map(a => {
        const label = document.querySelector(`label[for="${a.id}"]`);
        const raw = label ? label.textContent.trim() : '';
        return raw.replace(/^Add\s+/i, '').trim();
    });

    const addonTotal = selectedAddons.reduce((sum, addon) => {
        return sum + (parseFloat(addon.dataset.price) || 0);
    }, 0);

    const item = document.createElement('div');
    item.className = 'cart-item';

    item.innerHTML = `
        <div style="display: flex; align-items: center; gap: 10px;">
            <img src="${image}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;">
            <div style="flex: 1;">
                <div><strong>${name}</strong></div>
                ${addonNames.length ? `<div style="font-size: 0.9em; color: #555;">Add-ons: ${addonNames.join(', ')}</div>` : ''}
            </div>
            <button onclick="this.parentElement.parentElement.remove(); updateCartTotal()" style="background: none; border: none; color: red; cursor: pointer;">✖</button>
        </div>
    `;

    item.dataset.price = price;
    item.dataset.qty = quantity;
    item.dataset.addon = addonTotal;

    cartItems.appendChild(item);
    updateCartTotal();

    const notifContainer = document.getElementById('notifContainer');
    const notif = document.createElement('div');
    notif.className = 'notif';
    notif.innerText = '✅ Item added to cart!';
    notifContainer.appendChild(notif);

    setTimeout(() => {
        notif.remove();
    }, 4000);
}

function updateCartTotal() {
    const cartItems = document.querySelectorAll('.cart-item');
    let subtotal = 0;

    cartItems.forEach(item => {
        const price = parseFloat(item.dataset.price);
        const qty = parseInt(item.dataset.qty);
        const addon = parseFloat(item.dataset.addon);
        subtotal += (price + addon) * qty;
    });

    const vat = subtotal * 0.12;
    const shipping = 50;
    const total = subtotal + vat + shipping;

    document.getElementById('cartSubtotal').innerText = `₱${subtotal.toFixed(2)}`;
    document.getElementById('cartVAT').innerText = `₱${vat.toFixed(2)}`;
    document.getElementById('cartTotal').innerText = `₱${total.toFixed(2)}`;
}
