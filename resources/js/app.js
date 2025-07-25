import './bootstrap';

Pusher.logToConsole = true;

document.addEventListener('livewire:init', () => {
    window.userOrderIds.forEach(orderId => {
    Echo.private(`orders.${orderId}`)
        .listen('OrderStatusUpdated', (e) => {
            Livewire.dispatch('order-status-updated', e);
        });
    });
});
