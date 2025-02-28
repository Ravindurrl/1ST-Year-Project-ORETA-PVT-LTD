const customerList = [];

// Open Add Customer Form
function openAddCustomerForm() {
  document.getElementById("formTitle").innerText = "Add Customer";
  document.getElementById("customerForm").reset();
  document.getElementById("customerFormModal").style.display = "flex";
}

// Close the form
function closeForm() {
  document.getElementById("customerFormModal").style.display = "none";
}

// Add Customer
function addCustomer() {
  const id = document.getElementById("customerId").value;
  const name = document.getElementById("customerName").value;
  const telephone = document.getElementById("customerTelephone").value;
  const address = document.getElementById("customerAddress").value;
  const email = document.getElementById("customerEmail").value;

  customerList.push({ id, name, telephone, address, email });
  renderCustomerTable();
  closeForm();
}

// Render Customer Table
function renderCustomerTable() {
  const tbody = document.getElementById("customerList");
  tbody.innerHTML = "";
  customerList.forEach((customer, index) => {
    const row = `<tr>
      <td>${customer.id}</td>
      <td>${customer.name}</td>
      <td>${customer.telephone}</td>
      <td>${customer.address}</td>
      <td>${customer.email}</td>
      <td>
        <button onclick="editCustomer(${index})">Edit</button>
        <button onclick="deleteCustomer(${index})">Delete</button>
      </td>
    </tr>`;
    tbody.innerHTML += row;
  });
}

// Edit Customer
function editCustomer(index) {
  const customer = customerList[index];
  document.getElementById("formTitle").innerText = "Edit Customer";
  document.getElementById("customerId").value = customer.id;
  document.getElementById("customerName").value = customer.name;
  document.getElementById("customerTelephone").value = customer.telephone;
  document.getElementById("customerAddress").value = customer.address;
  document.getElementById("customerEmail").value = customer.email;
  document.getElementById("customerFormModal").style.display = "flex";
}

// Delete Customer
function deleteCustomer(index) {
  customerList.splice(index, 1);
  renderCustomerTable();
}
