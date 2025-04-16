// // Responsive Navbar Toggle
// const navLinks = document.querySelector('.nav-links');
// const menuToggle = document.querySelector('.navbar');

// menuToggle.addEventListener('click', () => {
//   navLinks.classList.toggle('show');
// });


  document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');

    hamburger.addEventListener('click', () => {
      navLinks.classList.toggle('active');
    });
  });

  document.addEventListener("DOMContentLoaded", () => {
    fetch('get_rooms.php')
      .then(response => response.json())
      .then(data => {
        const container = document.getElementById('roomsContainer');
  
        data.forEach(room => {
          const roomCard = document.createElement('div');
          roomCard.classList.add('room-card');
  
          roomCard.innerHTML = `
            <img src="${room.image_url}" alt="Room Image">
            <h3>${room.title}</h3>
            <p>${room.description}</p>
            <p><strong>Location:</strong> ${room.location}</p>
            <p><strong>Price:</strong> $${room.price} per night</p>
            <button class="book-btn" onclick="bookRoom(${room.room_id})">Book Now</button>
          `;
  
          container.appendChild(roomCard);
        });
      });
  });
  
  function bookRoom(roomId) {
    const checkIn = prompt("Enter Check-In Date (YYYY-MM-DD):");
    const checkOut = prompt("Enter Check-Out Date (YYYY-MM-DD):");
  
    if (checkIn && checkOut) {
      fetch('book_room.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `room_id=${roomId}&check_in=${checkIn}&check_out=${checkOut}`
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === "success") {
          alert(data.message);
        } else {
          showPopup(data.message);
        }
      });
    }
  }
  
  function showPopup(message) {
    const popup = document.createElement('div');
    popup.classList.add('popup');
  
    popup.innerHTML = `
      <div class="popup-content">
        <p>${message}</p>
        <button onclick="redirectToLogin()">Login</button>
        <button onclick="closePopup()">Cancel</button>
      </div>
    `;
  
    document.body.appendChild(popup);
  }
  
  function redirectToLogin() {
    window.location.href = 'auth.html';
  }
  
  function closePopup() {
    const popup = document.querySelector('.popup');
    if (popup) {
      popup.remove();
    }
  }
  

  const rediret=document.querySelector(".btn-primary");
    rediret.addEventListener("click",()=>{
        window.location.href="room.html";
    }
)