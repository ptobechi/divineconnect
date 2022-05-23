$("#register-logistics").submit(function (event) {
    event.preventDefault();

    //initialize form variables
    let shipping_method = document.getElementById("shipping_method").value;
    let order_date = document.getElementById("order_date").value;
    let s_name = document.getElementById("s_name").value;
    let r_name = document.getElementById("r_name").value;
    let s_email = document.getElementById("s_email").value;
    let r_email = document.getElementById("r_email").value;
    let s_pnumber = document.getElementById("s_pnumber").value;
    let r_pnumber = document.getElementById("r_pnumber").value;
    let city = document.getElementById("city").value;
    let postcode = document.getElementById("postcode").value;
    let state = document.getElementById("state").value;
    let billing_order_country = document.getElementById("billing_order_country").value;


    let data = {
        shipping_method: shipping_method,
        order_date: order_date,
        s_name: s_name,
        r_name: r_name,
        s_email: s_email,
        r_email: r_email,
        s_pnumber: s_pnumber,
        r_pnumber: r_pnumber,
        city: city,
        postcode: postcode,
        state: state,
        billing_order_country: billing_order_country,
        action: "register"
    }

    // disabled the submit button
    $("#submit_logistics").prop("disabled", true);
    $("#submit_logistics").html('<i class="fa fa-circle-o-notch fa-spin"></i> loading...');

    $.ajax({
        url: "PHP/logisticsController.php",
        method: "POST",
        enctype: 'multipart/form-data',
        data: data,
        success: function (data) {
            console.log(data);
            if (data == 201) {
                // window.location.href = "sign-in.html";
            } else if (data == 302) {
                document.getElementById("email").scrollIntoView();
                document.getElementById("email_msg").textContent = "Email address already exists";
                $("#submit_logistics").prop("disabled", false);
                $("#submit_logistics").html('<i class="fa fa-circle-o-notch fa-spin"></i> ...');
                return
            } else {
                // alert("Registration Failed");
                $("#submit_logistics").prop("disabled", false);
                $("#submit_logistics").html('Submit');
            }
        },
        error: function (e) {
            $("#submit_logistics").prop("disabled", false);
            $("#submit_logistics").html('Submit');
        }
    });

});


$("#track_logistics").submit(function (event) {
    event.preventDefault();

    const label_div = document.getElementById("tracking_modal");
    label_div.innerHTML = "";
    //initialize form variables
    let tracking_id = document.getElementById("tracking_id").value;

    let data = {
        tracking_id: tracking_id,
        action: "fetch"
    }

    // disabled the submit button
    $("#track_package").prop("disabled", true);
    $("#track_package").html('<i class="fa fa-circle-o-notch fa-spin"></i> ...');

    $.ajax({
        url: "admin/PHP/logisticsController.php",
        method: "POST",
        enctype: 'multipart/form-data',
        data: data,
        success: function (data) {
            console.log(data);
            if (data != 0) {
                $('#\\#myModal').modal('show');

                label_div.innerHTML += data;
                $("#track_package").prop("disabled", false);
                $("#track_package").html('<i class="fa fa-search"></i>');
            } else {

                // alert("Registration Failed");
                $("#track_package").prop("disabled", false);
                $("#track_package").html('Submit');
            }
        },
        error: function (e) {
            $("#track_package").prop("disabled", false);
            $("#track_package").html('Submit');
        }
    });

});

(function getAllPackage() {

    let data = {
        action: "fetch_all"
    }

    $.ajax({
        url: "PHP/logisticsController.php",
        method: "POST",
        enctype: 'multipart/form-data',
        data: data,
        success: function (data) {
            const label_div = document.getElementById("allPackage");
            label_div.innerHTML = "";
            console.log(data);
            label_div.innerHTML += data;

        },
        error: function (e) {
            $("#track_package").prop("disabled", false);
            $("#track_package").html('Submit');
        }
    });
})();

