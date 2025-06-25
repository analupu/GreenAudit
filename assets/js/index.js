$(function() {



    $('#btnAdaugaAparatNou').click(function() {
        var i = Number($('[id^=consumer_]').last().attr('data-localId')) + 1;

        $('#consumersWrapper').append('                 <div class="col-md-6" id="consumer_' + i + '" data-localId="' + i + '">\n' +
            '                      <div class="card mb-5 mx-3">\n' +
            '                          <div class="card-body">\n' +
            '                              <div class="form-floating mb-3">\n' +
            '                                  <input type="text" class="form-control" id="consumerBrand' + i + '" placeholder="Marca consumator" name="consumers[' + i + '][brand]" required/>\n' +
            '                                  <label for="consumerBrand' + i + '">Marca consumator</label>\n' +
            '                              </div>\n' +
            '                              <div class="form-floating mb-3">\n' +
            '                                  <input type="text" class="form-control" id="consumerEnergyClass' + i + '" placeholder="Clasa energetica consumator" name="consumers[' + i + '][energyClass]" required/>\n' +
            '                                  <label for="consumerEnergyClass' + i + '">Clasa energetica consumator</label>\n' +
            '                              </div>\n' +
            '                              <div class="form-floating mb-3">\n' +
            '                                  <input type="text" class="form-control" id="consumerName' + i + '" placeholder="Nume consumator" name="consumers[' + i + '][name]" required/>\n' +
            '                                  <label for="consumerName' + i + '">Nume consumator</label>\n' +
            '                              </div>\n' +
            '                              <div class="form-floating mb-3">\n' +
            '                                  <input type="number" class="form-control" id="consumerCount' + i + '" placeholder="Numar consumatori" name="consumers[' + i + '][count]" required/>\n' +
            '                                  <label for="consumerCount' + i + '">Numar consumatori</label>\n' +
            '                              </div>\n' +
            '                              <div class="form-floating mb-3">\n' +
            '                                  <input type="number" class="form-control" id="consumerRunTime' + i + '" placeholder="Ore funcionare consumator" name="consumers[' + i + '][runTime]" required/>\n' +
            '                                  <label for="consumerRunTime' + i + '">Ore funcionare consumator</label>\n' +
            '                              </div>\n' +
            '                              <div class="form-floating">\n' +
            '                                  <input type="number" class="form-control" id="consumerPower' + i + '" placeholder="Putere (W)" name="consumers[' + i + '][power]" required/>\n' +
            '                                  <label for="consumerPower' + i + '">Putere (W)</label>\n' +
            '                              </div>\n' +
            '                               <button class="btn btn-danger py-2 consumerDeleteButton" type="button" name="submit" id="btnStergeAparat" data-delete-id="consumer_' + i + '"><i\n' +
            '                                      class="fa-solid fa-trash"></i>\n' +
            '                                </button>\n' +
            '                          </div>\n' +
            '                      </div>\n' +
            '                 </div>');

            i++;
    });

    $('#consumersWrapper').on('click', '#btnStergeAparat', function(e) {
        e.preventDefault();
        var deleteId = $(this).attr('data-delete-id');
        Swal.fire({
            title: "Esti sigur?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Da",
            cancelButtonText: "Nu"
        }).then((result) => {
            if (result.isConfirmed) {
                $('#' + deleteId).remove();
            }
        });
    });
});