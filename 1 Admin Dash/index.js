document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    // User data with roles (no dashboard URLs)
    const users = [
       
        { username: "admin", password: "admin123", role: "Admin" },
        { username: "finmanager", password: "finance123", role: "Finance Manager" },
        { username: "salesmanager", password: "sales123", role: "Sales Manager" },
        { username: "hr Manager", password: "hr123", role: "HR manager" },
        { username: "Supervisor", password: "Supervisor123", role: "Supervisor" },
        { username: "Employee", password: "Employee123", role: "Employee" },
        { username: "DeliPartner", password: "DeliPartner123", role: "Delivery Partner" },
        { username: "Salesperson", password: "salesperson123", role: "Sales person" },
        { username: "Supplier", password: "Supplier123", role: "Supplier" },
        
    ];

    // Find the user based on the provided username and password
    const user = users.find(user => user.username === username && user.password === password);

    if (user) {
        // Redirect based on the user's role
        switch (user.role) {
            case "Supply Manager":
                window.location.href = "#suplymanager";
                break;
            case "Admin":
                <a href="adm.html"></a>
                break;
            case "HR Manager":
                window.location.href = "#hrmannager";
                break;
            case "Finance Manager":
                window.location.href = "#FinanceManager";
                break;
            case "seles and marketing Manager":
                    window.location.href = "#selesandmarketing";
                    break;
            case "Supervisor":
                window.location.href = "#supervisor";
                break;
            case "Employee": 
            window.location.href = "#employee";
            break;
            case "Delivery_Partner":
                window.location.href = "#deliverypartner";
                break;
            case "Supplier":
                window.location.href = "#supplier";
                break;
                
            default:
                document.getElementById('error-message').textContent = "No dashboard available for this role";
        }
    } else {
        // Show error message for invalid credentials
        document.getElementById('error-message').textContent = "Invalid username or password";
    }
});
