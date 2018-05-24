$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function makeid(){
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for( var i=0; i < 5; i++ )
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        return text;
    }
     function addNumformat(nStr){
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    function deleteNumformat(nStr){
        var spl = nStr.split(",");
        var x = "";
        for(i in spl){
            x =x+spl[i];
        }
        return x;
    }

    function removePriceFormat(form,data){
        var data_return = {};
        $.each(data,function(){
            if($(form).find('[name="'+this.name+'"]').hasClass('price')){
                data_return[this.name] = deleteNumformat(this.value);
            }else{
                data_return[this.name] = this.value;
            }
        });
        return data_return;
    }

    $.extend( true, $.fn.dataTable.defaults, {
        "sDom": "<'row'<'col-md-6 hidden-xs'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
        "oClasses": {
            "sLengthSelect": "form-control input-sm selectpicker",
            "sFilter": "pull-right",
            "sFilterInput": "form-control input-transparent ml-sm"
        },
        "processing": true,
        "serverSide": true,
        // Internationalisation. For more info refer to http://datatables.net/manual/i18n
        "language": {
            "aria": {
                "sortAscending": ": เรียงจากน้อยไปมาก",
                "sortDescending": ": เรียงจากมากไปน้อย"
            },
            "emptyTable": "ไม่พบข้อมูล",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": " ",
            "infoFiltered": "(filtered1 from _MAX_ total entries)",
            "lengthMenu": "_MENU_",
            "search": "Search:",
            "zeroRecords": "No matching records found"
        },
        responsive: true,
        "drawCallback": function( settings ) {
            $('.btn-tooltip').tooltip({
                placement : 'top',
                trigger : 'hover'
            });
        }
    } );
    $('[rel="tooltip"]').on('click', function () {
    $(this).tooltip('hide')
})
    $('body').on('keydown','.number-only',function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    $(".form_date").datetimepicker({
        autoclose: true,
        todayBtn: true,
        format: 'yyyy-mm-dd',
        minView : 2
    });
    $(".form_date_time").datetimepicker({
        autoclose: true,
        todayBtn: true,
        format: 'yyyy-mm-dd hh:ii'
    });
    $('body').on('click','.remove_date_time',function(){
        $(this).prev().val('');
    });
    $('body').on('click','.trigger_date_time',function(){
        $(this).prev().prev().click();
        $(this).prev().prev().trigger('click');
        $(this).prev().prev().focus();
    });

    $('.price').priceFormat({
        prefix: '',
        suffix: ''
    });

    $('.date-range').daterangepicker({
        timePicker: false,
        locale: {
            format: 'YYYY-MM-DD'
        }
    });

    $('.date-time-range').daterangepicker({
        timePicker: true,
        "timePicker24Hour": true,
        locale: {
            format: 'YYYY-MM-DD HH:mm'
        }
    });

    $('body').on('change','.upload_file',function(){
        var ele = $(this);
        var formData = new FormData();
        formData.append('file', ele[0].files[0]);
        $.ajax({
               url : url_gb+'/admin/upload_file',
               type : 'POST',
               data : formData,
               processData: false,  // tell jQuery not to process the data
               contentType: false,  // tell jQuery not to set contentType
               success : function(data) {
                   ele.closest('.form-group').find('.preview_file').html('<img src="'+data.link_preview+'" class="preview-file">');
                   ele.closest('.form-group').find('.value_name_file').val(data.path);
                   setTimeout(function(){
                        centerModals();
                   },100);
               }
        });
    });