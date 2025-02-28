const partners = [];

// Open Add Partner Form
function openAddPartnerForm() {
  document.getElementById("formTitle").innerText = "Add Delivery Partner";
  document.getElementById("partnerForm").reset();
  document.getElementById("partnerFormModal").style.display = "flex";
}

// Close the form
function closeForm() {
  document.getElementById("partnerFormModal").style.display = "none";
}

// Save Delivery Partner
function savePartner() {
  const id = document.getElementById("deliveryId").value;
  const name = document.getElementById("partnerName").value;
  const price = document.getElementById("deliveryPrice").value;

  partners.push({ id, name, price });
  renderPartnerTable();
  closeForm();
}

// Render Delivery Partner Table
function renderPartnerTable() {
  const tbody = document.getElementById("partnerList");
  tbody.innerHTML = "";
  partners.forEach((partner, index) => {
    const row = `<tr>
      <td>${partner.id}</td>
      <td>${partner.name}</td>
      <td>${partner.price}</td>
      <td>
        <button onclick="editPartner(${index})">Edit</button>
        <button onclick="deletePartner(${index})">Delete</button>
      </td>
    </tr>`;
    tbody.innerHTML += row;
  });
}

// Edit Delivery Partner
function editPartner(index) {
  const partner = partners[index];
  document.getElementById("formTitle").innerText = "Edit Delivery Partner";
  document.getElementById("deliveryId").value = partner.id;
  document.getElementById("partnerName").value = partner.name;
  document.getElementById("deliveryPrice").value = partner.price;
  document.getElementById("partnerFormModal").style.display = "flex";
}

// Delete Delivery Partner
function deletePartner(index) {
  partners.splice(index, 1);
  renderPartnerTable();
}

// Initial Render
renderPartnerTable();
