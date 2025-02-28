let supervisors = [];
let editIndex = -1;

// Open Add Supervisor Form
function openAddSupervisorForm() {
  document.getElementById("formTitle").innerText = "Add Supervisor";
  document.getElementById("supervisorForm").reset();
  editIndex = -1;
  document.getElementById("supervisorFormModal").style.display = "flex";
}

// Close the form
function closeForm() {
  document.getElementById("supervisorFormModal").style.display = "none";
}

// Save Supervisor
function saveSupervisor() {
  const name = document.getElementById("supervisorName").value;
  const email = document.getElementById("supervisorEmail").value;
  const phone = document.getElementById("supervisorPhone").value;
  const address = document.getElementById("supervisorAddress").value;

  if (editIndex === -1) {
    // Add new supervisor
    supervisors.push({ id: supervisors.length + 1, name, email, phone, address });
  } else {
    // Update existing supervisor
    supervisors[editIndex] = { ...supervisors[editIndex], name, email, phone, address };
    editIndex = -1;
  }
  
  renderSupervisorTable();
  closeForm();
}

// Render Supervisor Table
function renderSupervisorTable() {
  const supervisorList = document.getElementById("supervisorList");
  supervisorList.innerHTML = "";

  supervisors.forEach((supervisor, index) => {
    const row = `<tr>
      <td>${supervisor.id}</td>
      <td>${supervisor.name}</td>
      <td>${supervisor.email}</td>
      <td>${supervisor.phone}</td>
      <td>${supervisor.address}</td>
      <td>
        <button onclick="editSupervisor(${index})">Edit</button>
        <button onclick="deleteSupervisor(${index})">Delete</button>
      </td>
    </tr>`;
    supervisorList.innerHTML += row;
  });
}

// Edit Supervisor
function editSupervisor(index) {
  editIndex = index;
  const supervisor = supervisors[index];
  document.getElementById("formTitle").innerText = "Edit Supervisor";
  document.getElementById("supervisorName").value = supervisor.name;
  document.getElementById("supervisorEmail").value = supervisor.email;
  document.getElementById("supervisorPhone").value = supervisor.phone;
  document.getElementById("supervisorAddress").value = supervisor.address;
  document.getElementById("supervisorFormModal").style.display = "flex";
}

// Delete Supervisor
function deleteSupervisor(index) {
  supervisors.splice(index, 1);
  renderSupervisorTable();
}

// Initial Render
renderSupervisorTable();
