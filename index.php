<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Dropdowns</title>
</head>
<body>

    <form style="background-color: grey;">
        <hr>
        <label for="country" style="color:white;">Country:</label>
        <select id="country" name="country" style="background-color: grey; color:white;">
            <option value="">Select Country</option>
            <!-- Countries will be loaded here dynamically -->
        </select>

        <hr>

        <label for="state" style="color:white;">State:</label>
        <select id="state" name="state" style="background-color: grey; color:white;">
            <option value="">Select State</option>
            <!-- States will be loaded here dynamically -->
        </select>

        <hr>

        <label for="city" style="color:white;">City:</label>
        <select id="city" name="city" style="background-color: grey; color:white;">
            <option value="">Select City</option>
            <!-- Cities will be loaded here dynamically -->
        </select>
        <hr>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
    // Load countries when the page loads
    $.ajax({
        url: 'dynamic_data.php',
        type: 'GET',
        data: { type: 'countries' },
        dataType: 'json',
        success: function(data) {
            $('#country').append(data.map(country => `<option value="${country.id}">${country.name}</option>`));
        },
        error: function(xhr, status, error) {
            console.error("Error loading countries: ", error);
        }
    });

    // Load states based on selected country
    $('#country').change(function() {
        let countryId = $(this).val();
        $('#state').html('<option value="">Select State</option>'); // Reset state dropdown
        $('#city').html('<option value="">Select City</option>'); // Reset city dropdown
        if (countryId) {
            $.ajax({
                url: 'dynamic_data.php',
                type: 'GET',
                data: { type: 'states', country_id: countryId },
                dataType: 'json',
                success: function(data) {
                    $('#state').append(data.map(state => `<option value="${state.id}">${state.name}</option>`));
                },
                error: function(xhr, status, error) {
                    console.error("Error loading states: ", error);
                }
            });
        }
    });

    // Load cities based on selected state
    $('#state').change(function() {
        let stateId = $(this).val();
        $('#city').html('<option value="">Select City</option>'); // Reset city dropdown
        if (stateId) {
            $.ajax({
                url: 'dynamic_data.php',
                type: 'GET',
                data: { type: 'cities', state_id: stateId },
                dataType: 'json',
                success: function(data) {
                    $('#city').append(data.map(city => `<option value="${city.id}">${city.name}</option>`));
                },
                error: function(xhr, status, error) {
                    console.error("Error loading cities: ", error);
                }
            });
        }
    });
});
    </script>

</body>
</html>
