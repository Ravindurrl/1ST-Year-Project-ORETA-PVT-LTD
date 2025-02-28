const suppliers = [];

// Open Add Supplier Form
function openAddSupplierForm() {
  document.getElementById("formTitle").innerText = "Add Supplier";
  document.getElementById("supplierForm").reset();
  document.getElementById("supplierFormModal").style.display = "flex";
}

// Close the form
function closeForm() {
  document.getElementById("supplierFormModal").style.display = "none";
}

// Save Supplier
function saveSupplier() {
  const id = document.getElementById("supplierId").value;
  const name = document.getElementById("supplierName").value;
  const telephone = document.getElementById("supplierTelephone").value;
  const address = document.getElementById("supplierAddress").value;

  suppliers.push({ id, name, telephone, address });
  renderSupplierTable();
  closeForm();
}

// Render Supplier Table
function renderSupplierTable() {
  const tbody = document.getElementById("supplierList");
  tbody.innerHTML = "";
  suppliers.forEach((supplier, index) => {
    const row = `<tr>
      <td>${supplier.id}</td>
      <td>${supplier.name}</td>
      <td>${supplier.telephone}</td>
      <td>${supplier.address}</td>
      <td>
        <button onclick="editSupplier(${index})">Edit</button>
        <button onclick="deleteSupplier(${index})">Delete</button>
      </td>
    </tr>`;
    tbody.innerHTML += row;
  });
}

// Edit Supplier
function editSupplier(index) {
  const supplier = suppliers[index];
  document.getElementById("formTitle").innerText = "Edit Supplier";
  document.getElementById("supplierId").value = supplier.id;
  document.getElementById("supplierName").value = supplier.name;
  document.getElementById("supplierTelephone").value = supplier.telephone;
  document.getElementById("supplierAddress").value = supplier.address;
  document.getElementById("supplierFormModal").style.display = "flex";
}

// Delete Supplier
function deleteSupplier(index) {
  suppliers.splice(index, 1);
  renderSupplierTable();
}

// Initial Render
renderSupplierTable();
