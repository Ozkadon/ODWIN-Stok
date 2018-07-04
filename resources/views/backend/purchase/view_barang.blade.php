<div style="width:96%;margin:auto;" id="content-popup">
    <br/>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover table-bordered dt-responsive nowrap dataTable-purchase-barang" cellspacing="0" width="100%" id="table-media_<?=$id_count;?>">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga Beli</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script>
    $('#table-media_<?php echo $id_count; ?>').on('click', 'tbody tr', function(e){
        e.preventDefault();
        $('#id_bahan_baku_<?= $id_count; ?>').val($(this).find('td').html());
        $('#nama_bahan_baku_<?= $id_count; ?>').val($(this).find('td').next().next().html());
        $('#harga_<?= $id_count; ?>').val($(this).find('td').next().next().next().html());
        $.colorbox.close();
    });	

    $('.dataTable-purchase-barang').dataTable({
        processing: true,
        serverSide: true,
        ajax: "<?=url('backend/browse-barang/datatable');?>",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'kode', name: 'kode'},
            {data: 'nama', name: 'nama'},
            {data: 'harga_beli', name: 'harga_beli'},
        ],
        responsive: true
    });
</script>