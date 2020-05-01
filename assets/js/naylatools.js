$('.Proses').click(function(){
    $('#loadProses').addClass('spinner-border spinner-border-sm');
    $('.Proses').prop("disabled", true);
});

function prosesForm(){
    $("#simpan").on("click", function(){
        var valid = this.form.checkValidity();
        if (valid) {
            event.preventDefault();
            $('#simpan').prop("disabled", true);
            $('#loadForm').addClass('spinner-border spinner-border-sm');   
            var data = $("form").serialize(); 
            $.ajax({
                url: "sys/crud.php", 
                type: "POST",
                async: true,
                cache: false,
                data: data, 
                success: function(data){ 
                    if (data != 'gagal') {
                      $("#tutupModal").click();
                      pesan(data);
                    }else{
                        alert(data);
                        $('#simpan').prop("disabled", false);
                        $('#loadForm').removeClass('spinner-border spinner-border-sm');  
                    }
                },
            });
        }
    });
}

function pengumuman(isi, status, tutup){
    $('#pengumuman').load(encodeURI('modul.php?modul=pengumuman&isi='+isi+'&status='+status)).delay(5000);
    $('#tutupPengumuman').click();
}

function prosesNotif(id, link){
    $('#aksi').load('sys/crud.php?act=notifikasi&id='+id);
    if(link != null){
        $('#tampil').load(link);
    }
}
//modal load
function modal(url, ukuran){
    $('#tampilModal').html("");
    $("#jenisModal").removeClass('modal-xl');
    $("#jenisModal").removeClass('modal-sm');
    $("#jenisModal").removeClass('modal-lg');
    $("#jenisModal").addClass(ukuran);
    $('#tampilModal').load(url);
}
//pilih menu
function pilihMenu(menu, caption, cari) {
    var h;
    var e = document.getElementsByClassName("active");
    document.getElementById("loading").style.display = "block";
    for (h = 0; h < e.length; h++) {
        e[h].classList.remove("active");  
    } 
    document.getElementById("menu"+menu).classList.add("active");
    window.history.pushState("data","Title","?halaman="+menu);
    document.title=caption;
    $("#tampil").load('data?act='+menu);
    if(cari == true){
        $("#formCari").show();
        $("#formCari").load('modul?modul=cari&cari='+menu);
    }else{
        $("#formCari").hide();
    }
    $('#tampilModal').load('modul?modul=loading');
}

//Menu
(function ($, window) {

    $.fn.contextMenu = function (settings) {

        return this.each(function () {

            $(this).on("contextmenu", function (e) {
                if (e.ctrlKey) return;
                
                var $menu = $(settings.menuSelector)
                    .data("invokedOn", $(e.target))
                    .show()
                    .css({
                        position: "absolute",
                        left: getMenuPosition(e.clientX, 'width', 'scrollLeft'),
                        top: getMenuPosition(e.clientY, 'height', 'scrollTop')
                    })
                    .off('click')
                    .on('click', 'a', function (e) {
                        $menu.hide();
                
                        var $invokedOn = $menu.data("invokedOn");
                        var $selectedMenu = $(e.target);
                        
                        settings.menuSelected.call(this, $invokedOn, $selectedMenu);
                    });
                return false;
            });
            $('body').click(function () {
                $(settings.menuSelector).hide();
            });
        });
        
        function getMenuPosition(mouse, direction, scrollDir) {
            var win = $(window)[direction](),
                scroll = $(window)[scrollDir](),
                menu = $(settings.menuSelector)[direction](),
                position = mouse + scroll;
                        
            if (mouse + menu > win && menu < mouse) 
                position -= menu;
            
            return position;
        }    

    };
})(jQuery, window);
//edit data
function editData(td, tipe, halaman, tabel, kolom, where){
    var url = encodeURI('modul=editData&tipe='+tipe+'&td='+td+'&halaman='+halaman+'&tabel='+tabel+'&kolom='+kolom+'&where='+where);
	//alert(url);
	$("#"+td).load('modul.php?'+url);
}

//edit File
function editFile(td, span, tipe, actinfo, tabel, kolom, where, lokasi, nama){
    var url = encodeURI('modul=editFile&tipe='+tipe+'&td='+td+'&span='+span+'&actinfo='+actinfo+'&tabel='+tabel+'&kolom='+kolom+'&where='+where+'&lokasi='+lokasi+'&nama='+nama);
    //alert(url);
    $("#"+td).load('modul.php?'+url);
}

//limit
function limit(act, untuk, jml){
    document.getElementById("loading").style.display = "block";
	var url = encodeURI('sys/crud.php?act=limit&untuk='+untuk+'&lakukan='+jml);
	//alert('hallo');
    $('#aksi').load(url);
    $('#tampil').load('data.php?act='+act);
}

//Sort
function order(order, halaman){
    document.getElementById("loading").style.display = "block";
    $('#tampil').load('data.php?act='+halaman+'&order='+order);
}

//pagination
function pagination(act, halaman){
    document.getElementById("loading").style.display = "block";
	$('#tampil').load('data?act='+act+'&halaman='+halaman);
}
//search
function cari(str) {
    var act = $("#actcari").val();
    $('#cari').on('click', function(){
		var q = $('#q').val();
		$("#tampil").load(encodeURI('data.php?act='+act+'&q='+q));
	});
    if (str.length==0) { 
       $('#tampil').load('data?act='+act);
       return;
    }
    if (window.XMLHttpRequest) {
    	// code for IE7+, Firefox, Chrome, Opera, Safari
    	xmlhttp=new XMLHttpRequest();
    } else {  
    	// code for IE6, IE5
    	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
    	if (this.readyState==4 && this.status==200) {
       		document.getElementById("tampil").innerHTML=this.responseText;
    	}
    }
    $("#tampil").load(encodeURI('data.php?act='+act+'&q='+str));
}

//notifikasi
// var refreshId = setInterval(function(){
// $('#notifikasi1').load('modul.php?modul=notif');
// $('#notifikasi2').load('modul.php?modul=notifikasi');
// $('#peringatan1').load('modul.php?modul=notif2');
// $('#peringatan').load('modul.php?modul=notifikasi2');
// },10000); 

//dynamic button

$(function(){
 $(document).on('click', '.btn-add', function(e){
  e.preventDefault();

    var controlForm = $('.controls:first'),
    currentEntry = $(this).parents('.entry:first'),
    newEntry = $(currentEntry.clone()).appendTo(controlForm);

    newEntry.find('input').val('');
    controlForm.find('.entry:not(:last) .btn-add')
        .removeClass('btn-add').addClass('btn-remove')
        .removeClass('btn-success').addClass('btn-danger')
        .html('<span class="fa fa-minus-square"></span>');
    }).on('click', '.btn-remove', function(e) {
        $(this).parents('.entry:first').remove();

        e.preventDefault();
        return false;
       });
});