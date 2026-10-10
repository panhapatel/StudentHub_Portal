fetch("event.json")
    .then(function(response) {
        return response.json();
    })
    .then(function(events) {

        let upcomingEvents = document.getElementById("upcomingEvents");
        let completedEvents = document.getElementById("completedEvents");

        let today = new Date();
        today.setHours(0, 0, 0, 0);


        events.forEach(function(event) {

            let eventDate = new Date(event.date);
            eventDate.setHours(0, 0, 0, 0);


            let card = `
                <div class="event-card">

                    <h4>${event.name}</h4>

                    <hr>

                    <p>
                        <b>Date:</b> ${event.date}
                    </p>

                    <p>
                        <b>Time:</b> ${event.time}
                    </p>

                    <p>
                        <b>Venue:</b> ${event.venue}
                    </p>

                    <p>
                        ${event.details}
                    </p>

                </div>
            `;


            if (eventDate >= today) {

                upcomingEvents.innerHTML += card;

            }
            else {

                completedEvents.innerHTML += card;

            }

        });

    })
    .catch(function(error) {

        console.log("Error loading events:", error);

    });