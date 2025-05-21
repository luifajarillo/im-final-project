let qty = 1;

function openModal(title, image, description, price) {
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalImage').src = image;
    document.getElementById('modalDesc').innerText = description;
    document.getElementById('modalPrice').innerText = price;
    document.getElementById('qtyValue').innerText = qty = 1;
    document.getElementById('itemModal').style.display = 'flex';

     // Reset all addon checkboxes
    const checkboxes = document.querySelectorAll('#checklist input[type="checkbox"]');
    checkboxes.forEach(checkbox => checkbox.checked = false);
}

function closeModal() {
    document.getElementById('itemModal').style.display = 'none';
}

function changeQty(amount) {
    qty = Math.max(1, qty + amount);
    document.getElementById('qtyValue').innerText = qty;
}

// CART MODAL
const cartBtn = document.getElementById("cartBtn");
const cartModal = document.getElementById("cartModal");

if (cartBtn) {
    cartBtn.addEventListener("click", showCart);
}

function showCart() {
    cartModal.style.display = "flex";
}

function closeCart() {
    console.log("closeCart called");
    cartModal.style.display = "none";
}

// Click outside modal to close
window.addEventListener("click", (e) => {
    if (e.target === cartModal) {
        closeCart();
    }
});

// One working listener
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

    const selectedAddons = Array.from(document.querySelectorAll('.addons input:checked'));
    const addonNames = selectedAddons.map(a => {
        const label = document.querySelector(`label[for="${a.id}"]`);
        const raw = label ? label.textContent.trim() : '';
        return raw.replace(/^Add\s+/i, '').trim();
    });

    const addonPrices = {
        "01": 0,   // Spring Onions
        "02": 0,   // Chili Garlic
        "03": 5,   // Garlic Chips
        "04": 17,  // Extra Egg
        "05": 35   // Tokwa't Baboy
    }; 


    const addonTotal = selectedAddons.reduce((sum, addon) => {
        return sum + (addonPrices[addon.id] || 0);
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
