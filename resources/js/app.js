import './bootstrap';

import Alpine from 'alpinejs';

document.addEventListener('alpine:init', () => {
    const userId = window.userId || 'guest';
    const cartKey = 'cart_items_' + userId;
    const addressListKey = 'address_list_' + userId;
    const addressSelectedKey = 'address_selected_' + userId;
    const ordersListKey = 'orders_list_' + userId;

    Alpine.store('orders', {
        list: JSON.parse(localStorage.getItem(ordersListKey) || '[]'),
        
        save() {
            localStorage.setItem(ordersListKey, JSON.stringify(this.list));
        },
        
        create(cartItems, cartTotal, bank, address) {
            const id = 'INV/' + new Date().toISOString().slice(0,10).replace(/-/g,'') + '/' + Date.now().toString().slice(-6);
            const newOrder = {
                id: id,
                date: new Date().toISOString(),
                items: JSON.parse(JSON.stringify(cartItems)),
                total: cartTotal,
                bank: bank,
                address: JSON.parse(JSON.stringify(address || {})),
                status: 'belum-bayar'
            };
            this.list.unshift(newOrder); // always add to top
            this.save();
            return id;
        },
        
        get(id) {
            return this.list.find(o => o.id === id);
        },
        
        updateStatus(id, newStatus) {
            const order = this.list.find(o => o.id === id);
            if (order) {
                order.status = newStatus;
                this.save();
            }
        }
    });

    Alpine.store('cart', {
        items: JSON.parse(localStorage.getItem(cartKey) || '[]'),
        
        save() {
            localStorage.setItem(cartKey, JSON.stringify(this.items));
        },
        
        add(product, qty = 1) {
            const existing = this.items.find(i => i.id === product.id);
            if (existing) {
                existing.quantity += parseInt(qty);
            } else {
                this.items.push({ ...product, quantity: parseInt(qty) });
            }
            this.save();
        },
        
        remove(id) {
            this.items = this.items.filter(i => i.id !== id);
            this.save();
        },
        
        updateQuantity(id, change) {
            const item = this.items.find(i => i.id === id);
            if (item) {
                item.quantity += change;
                if (item.quantity <= 0) {
                    this.remove(id);
                } else {
                    this.save();
                }
            }
        },
        
        get total() {
            return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        },
        
        get count() {
            return this.items.reduce((sum, item) => sum + item.quantity, 0);
        }
    });

    Alpine.store('address', {
        list: JSON.parse(localStorage.getItem(addressListKey) || '[]'),
        selectedId: localStorage.getItem(addressSelectedKey) && localStorage.getItem(addressSelectedKey) !== 'null' ? localStorage.getItem(addressSelectedKey) : null,
        
        get hasValidAddress() {
            // Evaluates truthfully only if array has content AND selectedId is an actual truthy non-"null" string
            return this.list.length > 0 && this.selectedId !== null && this.selectedId !== 'null' && this.selectedId !== '';
        },

        save() {
            localStorage.setItem(addressListKey, JSON.stringify(this.list));
            if (this.selectedId && this.selectedId !== 'null') {
                localStorage.setItem(addressSelectedKey, this.selectedId);
            } else {
                localStorage.removeItem(addressSelectedKey);
            }
        },
        
        add(addressData) {
            const id = Date.now().toString();
            this.list.push({ id, ...addressData });
            if (this.list.length === 1) {
                this.selectedId = id;
            }
            this.save();
        },
        
        remove(id) {
            this.list = this.list.filter(a => a.id !== id);
            if (this.selectedId === id) {
                this.selectedId = this.list.length > 0 ? this.list[0].id : null;
            }
            this.save();
        },
        
        select(id) {
            this.selectedId = id;
            this.save();
        }
    });
});

window.Alpine = Alpine;

Alpine.start();
