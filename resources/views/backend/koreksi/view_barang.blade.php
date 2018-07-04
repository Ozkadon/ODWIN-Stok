<div style="width:96%;margin:auto;" id="content-popup">
    <br/>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover table-bordered dt-responsive nowrap dataTable-koreksi-barang" cellspacing="0" width="100%" id="table-media">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Stok Awal</th>
                        <th>Stok Total</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script>
    $('#table-media').on('click', 'tbody tr', function(e){
        e.preventDefault();
        $('#id_bahan_baku').val($(this).find('td').html());
        $('#nama_bahan_baku').val($(this).find('td').next().next().html());
        $.colorbox.close();
    });	

    $('.dataTable-koreksi-barang').dataTable({
        processing: true,
        serverSide: true,
        ajax: "<?=url('backend/browse-barang/datatable');?>",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'kode', name: 'kode'},
            {data: 'nama', name: 'nama'},
            {data: 'stok_awal', name: 'stok_awal'},
            {data: 'stok_total', name: 'stok_total'},
        ],
        responsive: true
    });
</script>