const products = [
  { id: 1, name: "Door 1", category: "door", image: "img1.jpg" },
  { id: 2, name: "Door 2", category: "door", image: "img2.jpg" },
  { id: 3, name: "Door 3", category: "door", image: "img3.jpg" },
  { id: 4, name: "Door 4", category: "door", image: "img4.jpg" },
  { id: 6, name: "Window 1", category: "window", image: "windows1.jpg" },
  { id: 7, name: "Window 2", category: "window", image: "windows2.jpg" },
  { id: 8, name: "Window 3", category: "window", image: "windows3.jpg" },
  { id: 9, name: "Window 4", category: "window", image: "windows4.jpg" },
  { id: 3, name: "Griffin 1", category: "griffin", image: "Griffin.jpg" },
  { id: 4, name: "Roofing 1", category: "roofing", image: "RoofingSheets.jpg" },
  
];

let cart = [];

function displayProducts(filter = "all") {
  const productList = document.getElementById("product-list");
  productList.innerHTML = "";
  const filteredProducts = filter === "all" ? products : products.filter(p => p.category === filter);
  filteredProducts.forEach(product => {
    const card = document.createElement("div");
    card.className = "product-card";
    card.innerHTML = `
      <img src="${product.image}" alt="${product.name}" />
      <h4>${product.name}</h4>
      <button onclick="addToCart(${product.id})">Add to Cart</button>
    `;
    productList.appendChild(card);
  });
}

function addToCart(productId) {
  const product = products.find(p => p.id === productId);
  cart.push(product);
  alert(`${product.name} added to cart`);
}

function viewCart() {
  alert("Cart: " + cart.map(p => p.name).join(", "));
}

function filterProducts(category) {
  displayProducts(category);
}

function searchProducts() {
  const query = document.getElementById("search-input").value.toLowerCase();
  const filtered = products.filter(p => p.name.toLowerCase().includes(query));
  displayProducts(filtered.map(p => p.category));
}

document.addEventListener("DOMContentLoaded", () => displayProducts());
