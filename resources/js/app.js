import './bootstrap';

Pusher.logToConsole = true;
document.addEventListener("DOMContentLoaded", function () {
    const orderInput = document.getElementById("orderId");

    if (orderInput) {
        const orderId = orderInput.value;
        Echo.private("orders." + orderId)
        .listen("OrderStatusUpdated", (e) => { // Use event class name, a custom event name works only with pusher
            alert("Order status updated: " + JSON.stringify(e));
        });
    } else {
        console.error("Order ID not found in the DOM.");
    }
    
});
