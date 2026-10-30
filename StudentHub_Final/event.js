fetch("event.json")
    .then(function (response) {
        return response.json();
    })
    .then(function (events) {

        let upcomingEvents = document.getElementById("upcomingEvents");
        let completedEvents = document.getElementById("completedEvents");

        let today = new Date();
        today.setHours(0, 0, 0, 0);

        events.forEach(function (event) {

            let eventDate = new Date(event.date);
            eventDate.setHours(0, 0, 0, 0);

            let isUpcoming = eventDate >= today;

            let card = `
                <div class="event-card">

                    <h4>${event.name}</h4>

                    <hr>

                    <p><b>Date:</b> ${event.date}</p>

                    <p><b>Time:</b> ${event.time}</p>

                    <p><b>Venue:</b> ${event.venue}</p>

                    <p>${event.details}</p>

                    ${isUpcoming
                        ? `<button type="button" class="register-event" data-id="${event.id}">Register</button>
                           <p class="register-msg"></p>`
                        : ""}

                </div>
            `;

            if (isUpcoming) {
                upcomingEvents.innerHTML += card;
            } else {
                completedEvents.innerHTML += card;
            }

        });

    })
    .catch(function (error) {

        console.log("Error loading events:", error);

    });


document.addEventListener("click", function (e) {

    let btn = e.target.closest(".register-event");

    if (!btn) {
        return;
    }

    let msg = btn.nextElementSibling;
    msg.textContent = "Registering...";

    fetch("register_event.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ event_id: Number(btn.dataset.id) })
    })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            msg.textContent = data.message;
        })
        .catch(function () {
            msg.textContent = "Error registering for event!";
        });

});