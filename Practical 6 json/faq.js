fetch("faq.json")
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {

        let faqList = document.getElementById("faqList");

        data.forEach(function(faq, index) {

            let article = document.createElement("article");

            article.className = "faq-item";

            article.innerHTML = `
                <button class="faq-question"
                        type="button"
                        aria-expanded="false">

                    ${index + 1}. ${faq.question}

                </button>

                <div class="faq-answer" hidden>

                    ${faq.answer}

                </div>

                <br>
            `;

            faqList.appendChild(article);

        });

    })
    .catch(function(error) {

        console.log("Error loading FAQ JSON:", error);

    });


document.getElementById("faqList").addEventListener("click", function(event) {

    let question = event.target.closest(".faq-question");

    if (!question) {
        return;
    }

    let answer = question.nextElementSibling;

    let isOpen =
        question.getAttribute("aria-expanded") === "true";

    question.setAttribute(
        "aria-expanded",
        String(!isOpen)
    );

    answer.hidden = isOpen;

});