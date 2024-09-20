window.defaultFileUploadConfig = {
    language: "es",
    fileActionSettings: {
        uploadIcon: '<i class="fas fa-upload"></i>',
        removeIcon: '<i class="fas fa-trash"></i>',
        zoomIcon: '<i class="fas fa-search-plus"></i>',
    },
    previewZoomButtonIcons: {
        toggleheader: '<i class="fas fa-arrows-alt-v"></i>',
        fullscreen: '<i class="fas fa-expand"></i>',
        borderless: '<i class="fas fa-expand-arrows-alt"></i>',
        // close: '<i class="fas fa-window-close"></i>'
    },
    uploadIcon: '<i class="fas fa-upload"></i>',
    removeIcon: '<i class="fas fa-trash"></i>',
    zoomIcon: '<i class="fas fa-search-plus"></i>',
};


$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });

    moment.updateLocale('es', {
        months: 'Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre'.split('_'),
        monthsShort: 'Ene._Feb._Mar._Abr._May._Jun._Jul._Ago._Sept._Oct._Nov._Dec.'.split('_'),
        weekdays: 'Domingo_Lunes_Martes_Miercoles_Jueves_Viernes_Sabado'.split('_'),
        weekdaysShort: 'Dom._Lun._Mar._Mier._Jue._Vier._Sab.'.split('_'),
        weekdaysMin: 'Do_Lu_Ma_Mi_Ju_Vi_Sa'.split('_')
    });

    $(document).delegate('.delete-item', 'click', function () {
        let confirmation = confirm('¿Estás seguro que deseas eliminar este elemento?');

        if (!confirmation) return;

        $(this).closest('form').submit();
    });

    $(document).delegate('.approve-item', 'click', function () {
        let title = $(this).data('title')
        let confirmation = confirm(title ? title : lang.js_common.element_approve);

        if (!confirmation) return;

        $(this).closest('form').submit();
    });

    $(document).delegate('.disapprove-item', 'click', function () {
        let confirmation = confirm( lang.js_common.element_disapprove );

        if (!confirmation) return;

        $(this).closest('form').submit();
    });

    $(window).on('load', function () {

        //======================MODAL===========================
        window.onhashchange = function () {
            if (window.location.hash == '#create') {
                $('.modal[id*="create"]').modal('show');
            } else if (window.location.hash == '#incomes') {
                $('.modal[id*="incomes"]').modal('show');
            } else if (window.location.hash == '#expenses') {
                $('.modal[id*="expenses"]').modal('show');
            }
        }
    
        if (window.location.hash == '#create') {
            $('.modal[id*="create"]').modal('show');
        } else if (window.location.hash == '#incomes'){
            $('.modal[id*="incomes"]').modal('show');
        } else if (window.location.hash == '#expenses'){
            $('.modal[id*="expenses"]').modal('show');
        }

        $('.modal-reset').click(function () {

            const params = new URLSearchParams(window.location.search)
            let replace = '';

            if(params.has('affiliate'))
                replace = '?affiliate=1#create';
            else
                replace = '#create';

            if (!$(".form-modal-dismiss").hasClass('dismiss-create-beneficiary'))
                window.location.href = window.location.href.replace(replace, ''); 
        })

        $('.modal-reset-incomes').click(function () {
            window.location.href = window.location.pathname
        })

        $('.modal-reset-expenses').click(function () {
            window.location.href = window.location.pathname
        })

        //================================
        $('.btn-reset').click(function () {
            setTimeout(() => {
                const table = $('table.table').DataTable();
                
                $('table.table').find('input').val('');
                $('table.table').find('select').prop('selectedIndex',0);
                $('table.table').find('checkbox').attr('checked',false);
                $('table.table').find('input, select,checkbox').change();
                table.draw();
            }, 100);
        });

        $('table.table thead tr:eq(1) th').each(function (i) {
            const table = $('table.table').DataTable();

            $('input, select', this).on('keyup change', function () {
                if (table.column(i).search() !== this.value && this.value !== 'Limpiar') {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        $('.multiselect').bootstrapDualListbox({});
    });

    var toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote'],

        [{ 'header': 1 }, { 'header': 2 }],               // custom button values
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        // [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
        [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
        [{ 'direction': 'rtl' }],                         // text direction

        // [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
        // [{ 'font': [] }],
        [{ 'align': [] }],
        ["image", "code-block"],

        ['clean']                                         // remove formatting button
    ];

    window.toolbarOptions = toolbarOptions;

});


//Permite configurar el formato de los inputs html para que acepten 
//Alphanumeric, numeric o alpha
(function($){

    $.fn.alphanumeric = function(p) {

        p = $.extend({
            ichars: "!@#$%^&*()+=[]\\\';,/{}|\":<>?~`.- ",
            nchars: "",
            allow: ""
        }, p);

        return this.each(function(){

            if (p.nocaps) p.nchars += "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            if (p.allcaps) p.nchars += "abcdefghijklmnopqrstuvwxyz";

            s = p.allow.split('');
            for ( i=0;i<s.length;i++) if (p.ichars.indexOf(s[i]) != -1) s[i] = "\\" + s[i];
            p.allow = s.join('|');

            var reg = new RegExp(p.allow,'gi');
            var ch = p.ichars + p.nchars;
            ch = ch.replace(reg,'');

            $(this).keypress(function (e){

                if (!e.charCode) k = String.fromCharCode(e.which);
                else k = String.fromCharCode(e.charCode);

                if (ch.indexOf(k) != -1) e.preventDefault();
                if (e.ctrlKey&&k=='v') e.preventDefault();

            });

            $(this).bind('contextmenu',function () {return false});

        });

    };

    $.fn.numeric = function(p) {

        var az = "abcdefghijklmnopqrstuvwxyz";
        az += az.toUpperCase();

        p = $.extend({
            nchars: az
        }, p);
         
        return this.each (function(){
            $(this).alphanumeric(p);
        });

    };

    $.fn.alpha = function(p) {

        var nm = "1234567890";

        p = $.extend({
            nchars: nm
        }, p);

        return this.each (function(){
            $(this).alphanumeric(p);
        });

    };

})(jQuery);