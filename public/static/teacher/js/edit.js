$(function () {
    $('select[name="living_country_code"]').on('change', function () {
        generateCities();
    });

    function generateProvinces() {
        var provinceSelector = $('#home_province_id');
        citySelector.empty();
        Boilerplate.provinces.forEach(function (province) {
            if( province.country_code == $('#nationality_country_code').val() ) {
                provinceSelector.append('<option value="' + province.id + '">' + province.name + '</option>');
            }
        });
    }

    $('select[name="nationality_country_code"]').on('change', function () {
        generateProvinces();
    });

    function generateCities() {
        var citySelector = $('#living_city_id');
        citySelector.empty();
        Boilerplate.cities.forEach(function (city) {
            if( city.country_code == $('#living_country_code').val() ) {
                citySelector.append('<option value="' + city.id + '">' + city.name + '</option>');
            }
        });
    }

});
