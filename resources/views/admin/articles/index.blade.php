<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <x-slot name="header">Artikel</x-slot>

                <button id="open-add-modal-button" class="bg-green-500 text-white px-4 py-2 mb-4 rounded hover:bg-green-600 transition">Tambah Artikel</button>

                <table id="article-table" class="min-w-full table-auto text-sm text-left text-gray-500">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Judul</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Penulis</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Gambar</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Tanggal Mulai</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Tanggal Berakhir</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div id="article-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-4 rounded-md">
            <h3 id="modal-title" class="text-lg mb-4">Tambah Artikel</h3>

            <form id="article-form" method="POST" enctype="multipart/form-data" class="p-6 bg-white shadow-lg rounded-lg">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-gray-700 font-medium">Judul</label>
                        <input type="text" id="title" name="title" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label for="start_date" class="block text-gray-700 font-medium">Tanggal Mulai</label>
                        <input type="date" id="start_date" name="start_date" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label for="end_date" class="block text-gray-700 font-medium">Tanggal Akhir</label>
                        <input type="date" id="end_date" name="end_date" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label for="meta_tags" class="block text-gray-700 font-medium">Meta Tags</label>
                        <input type="text" name="meta_tags" id="meta_tags" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan Meta Tags" />
                    </div>
                    <div>
                        <label for="content" class="block text-gray-700 font-medium">Konten</label>
                        <textarea id="content" name="content" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                    </div>
                    <div>
                        <label for="tags" class="block text-gray-700 font-medium">Tags</label>
                        <input type="text" name="tags" id="tags" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan tag, pisahkan dengan koma" />
                    </div>
                    <div>
                        <label for="image" class="block text-gray-700 font-medium">Gambar</label>
                        <input type="file" id="image" name="image" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" accept="image/*">
                    </div>
                    <div class="col-span-2 mt-6 flex justify-end gap-4">
                        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Simpan</button>
                        <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">Batal</button>
                    </div>
                </div>
            </form>
            
            
        </div>
    </div>
</x-app-layout>
<link href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

<script>
    let tags = [];    

    $(document).ready(function() {
        $('#open-add-modal-button').click(function() {
            openAddModal();
        });
        $('#article-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.articles.index") }}',
            columns: [
                { data: 'title', name: 'title' },
                { data: 'author', name: 'author' },
                { data: 'image', name: 'image', orderable: false, searchable: false },
                { data: 'start_date', name: 'start_date' },
                { data: 'enddate', name: 'end_date' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false },
            ]
        });
        
    });
    function openAddModal() {
        $('#modal-title').text('Tambah Artikel'); 
        $('#article-form')[0].reset(); 
        $('#article-form').attr('action', '/admin/articles');
        $('#article-modal').removeClass('hidden');
        $('#article-form').attr('method', 'POST');
        $('#article-form').append('<input type="hidden" name="_method" value="POST">');
    }
    // Fungsi untuk menambah artikel
    $('#article-form').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const actionUrl = $(this).attr('action');
        const method = $(this).attr('method') || 'POST';

        $.ajax({
            url: actionUrl,
            method: method,
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#submit-button').prop('disabled', true);
            },
            success: function(response) {
                console.log(response.success);
                if(response.success) {
                    $('#article-table').DataTable().ajax.reload();

                    closeModal();
                    Swal.fire(
                        'Artikel berhasil disimpan!',
                        response.message,
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Terjadi kesalahan!',
                        'Artikel gagal menyimpan.',
                        'error'
                    );
                }
            },
            complete: function() {
                $('#submit-button').prop('disabled', false);
            }
        });
    });


    function editArticle(id) {
        $.get(`/admin/articles/${id}`, function(data) {
            if (data) {
                var startDate = moment(data.data.start_date, 'YYYY-MM-DD');
                var endDate = moment(data.data.end_date, 'YYYY-MM-DD');

                $('#title').val(data.data.title);
                $('#author').val(data.data.author);
                if (startDate.isValid()) {
                    $('#start_date').val(startDate.format('YYYY-MM-DD'));
                }
                if(endDate.isValid()){
                    $('#end_date').val(endDate.format('YYYY-MM-DD'));
                }
                $('#content').val(data.data.content);
                $('#tags').val(data.data.tags);
                $('#meta_tags').val(data.data.meta_tags);
                $('#article-form').attr('action', `/admin/articles/${id}`);
                $('#article-form').attr('method', 'POST');
                $('#article-form').append('<input type="hidden" name="_method" value="PUT">');
                $('#modal-title').text('Edit Artikel');
                $('#article-modal').removeClass('hidden');
            } else {
                alert('Artikel tidak ditemukan');
            }
        }).fail(function() {
            alert('Terjadi kesalahan saat mengambil data artikel.');
        });
    }

    function closeModal() {
        $('#article-modal').addClass('hidden');
    }
    function deleteArticle(id){
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak bisa mengembalikan artikel ini setelah dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/articles/' + id,
                    method: 'DELETE',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Dihapus!',
                                response.message,
                                'success'
                            );
                            $('#article-table').DataTable().ajax.reload();
                        } else {
                            Swal.fire(
                                'Gagal!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Terjadi kesalahan!',
                            'Artikel gagal dihapus.',
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>
