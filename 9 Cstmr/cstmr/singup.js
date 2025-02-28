document.getElementById("signupForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form from submitting immediately

    // Form validation
    const name = document.getElementById("customerName").value.trim();
    const telephone = document.getElementById("customerTelephone").value.trim();
    const address = document.getElementById("customerAddress").value.trim();
    const email = document.getElementById("customerEmail").value.trim();

    let isValid = true;

    // Validate each field
    if (!name) {
        alert("Customer Name is required!");
        isValid = false;
    }

    if (!telephone) {
        alert("Customer Telephone is required!");
        isValid = false;
    }

    if (!address) {
        alert("Customer Address is required!");
        isValid = false;
    }

    if (!email || !email.includes("@")) {
        alert("A valid Customer Email is required!");
        isValid = false;
    }

    // If all fields are valid
    if (isValid) {
        alert("Form submitted successfully!");
        // Add your form submission logic here
        // Example: Send data to a backend API
        this.submit();
    }
});
