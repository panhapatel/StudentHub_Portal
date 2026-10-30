document.addEventListener("DOMContentLoaded", function () {

    function fillProfile(data) {
            document.getElementById("profileName").value = data.name || "";
            document.getElementById("enrollment").value = data.enrollment || "";
            document.getElementById("dob").value = data.dob || "";

            if (data.gender === "Male") {
                document.getElementById("male").checked = true;
            } else if (data.gender === "Female") {
                document.getElementById("female").checked = true;
            }

            document.getElementById("department").value = data.department || "";
            document.getElementById("course").value = data.course || "";
            document.getElementById("semester").value = data.semester || "";
            document.getElementById("cgpa").value = data.cgpa || "";
            document.getElementById("mobile").value = data.mobile || "";
            document.getElementById("collegeEmail").value = data.collegeEmail || "";
            document.getElementById("personalEmail").value = data.personalEmail || "";
            document.getElementById("address").value = data.address || "";
    }

    fetch("get_profile.php")
        .then(response => {
            if (!response.ok) {
                throw new Error("No saved profile");
            }
            return response.json();
        })
        .then(data => {
            if (!data || !data.enrollment) {
                throw new Error("Profile empty");
            }
            fillProfile(data);
        })
        .catch(() => {
            fetch("profile.json")
                .then(response => response.json())
                .then(fillProfile)
                .catch(error => console.log(error));
        });

    document.getElementById("clearProfile").addEventListener("click", function () {
        document.querySelectorAll(
            "#profileName, #enrollment, #dob, #department, #course, #semester, #cgpa, #mobile, #collegeEmail, #personalEmail, #address"
        ).forEach(field => field.value = "");

        document.querySelectorAll('input[name="gender"]').forEach(r => r.checked = false);
        document.getElementById("saveMessage").textContent = "";
    });

    document.getElementById("saveProfile").addEventListener("click", function () {

        const genderElement = document.querySelector('input[name="gender"]:checked');

        const profile = {
            name: document.getElementById("profileName").value.trim(),
            enrollment: document.getElementById("enrollment").value.trim(),
            dob: document.getElementById("dob").value,
            gender: genderElement ? genderElement.value : "",
            department: document.getElementById("department").value.trim(),
            course: document.getElementById("course").value,
            semester: document.getElementById("semester").value,
            cgpa: document.getElementById("cgpa").value,
            mobile: document.getElementById("mobile").value.trim(),
            collegeEmail: document.getElementById("collegeEmail").value.trim(),
            personalEmail: document.getElementById("personalEmail").value.trim(),
            address: document.getElementById("address").value.trim()
        };

        const message = document.getElementById("saveMessage");
        message.textContent = "Saving profile...";

        fetch("save_profile.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(profile)
        })
        .then(response => response.json())
        .then(data => {
            message.textContent = data.message;
        })
        .catch(error => {
            message.textContent = "Error saving profile!";
            console.log(error);
        });
    });
});
