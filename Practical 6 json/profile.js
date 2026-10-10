fetch("profile.json")
    .then(response => response.json())
    .then(data => {

        document.getElementById("profileName").value = data.name;
        document.getElementById("enrollment").value = data.enrollment;
        document.getElementById("dob").value = data.dob;

        if (data.gender === "Male") {
            document.getElementById("male").checked = true;
        }
        else if (data.gender === "Female") {
            document.getElementById("female").checked = true;
        }
        document.getElementById("department").value = data.department;
        document.getElementById("course").value = data.course;
        document.getElementById("semester").value = data.semester;
        document.getElementById("cgpa").value = data.cgpa;
        document.getElementById("mobile").value = data.mobile;
        document.getElementById("collegeEmail").value = data.collegeEmail;
        document.getElementById("personalEmail").value = data.personalEmail;
        document.getElementById("address").value = data.address;

    })
    .catch(error => {
        console.log("Error loading JSON:", error);
    });