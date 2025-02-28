document.getElementById('discount-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const discountId = document.getElementById('discount-id').value;
    const discountedItemPrice = parseFloat(document.getElementById('discounted-item-price').value);
    const discountedItemType = document.getElementById('discounted-item-type').value;
    const discountPeriodStart = document.getElementById('discount-period-start').value;
    const discountPeriodEnd = document.getElementById('discount-period-end').value;
    
    const table = document.getElementById('discount-records');
    const row = table.insertRow();
    
    const cell1 = row.insertCell(0);
    const cell2 = row.insertCell(1);
    const cell3 = row.insertCell(2);
    const cell4 = row.insertCell(3);
    const cell5 = row.insertCell(4);
    
    cell1.textContent = discountId;
    cell2.textContent = discountedItemPrice;
    cell3.textContent = discountedItemType;
    cell4.textContent = `${discountPeriodStart} to ${discountPeriodEnd}`;
    cell5.innerHTML = '<button onclick="editDiscount(this)">Edit</button><button onclick="deleteDiscount(this)">Delete</button>';
    
    document.getElementById('discount-form').reset();
});

function editDiscount(button) {
    const row = button.parentElement.parentElement;
    document.getElementById('discount-id').value = row.cells[0].textContent;
    document.getElementById('discounted-item-price').value = row.cells[1].textContent;
    document.getElementById('discounted-item-type').value = row.cells[2].textContent;
    const [start, end] = row.cells[3].textContent.split(' to ');
    document.getElementById('discount-period-start').value = start;
    document.getElementById('discount-period-end').value = end;
    
    row.remove();
}

function deleteDiscount(button) {
    const row = button.parentElement.parentElement;
    row.remove();
}