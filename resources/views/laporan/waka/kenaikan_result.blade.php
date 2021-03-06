<table class="table table-bordered">
	<thead>
		<tr>
			<th width="50%" class="text-center" style="vertical-align:middle;">Nama Peserta Didik</th>
			<th width="25%" class="text-center" style="vertical-align:middle;">Status Kenaikan</th>
			<th width="25%" class="text-center" style="vertical-align:middle;">Ke Kelas</th>
		</tr>
	</thead>
	<tbody>
		@foreach($get_siswa as $siswa)
		<tr>
			<td>
				<input type="hidden" name="anggota_rombel_id[]" value="{{$siswa->anggota_rombel_id}}" />
				<input type="hidden" id="kelas_sekarang" value="{{$siswa->rombongan_belajar->nama}}" />
				<input type="hidden" id="rombongan_belajar_id"
					value="{{$siswa->rombongan_belajar->rombongan_belajar_id}}" />
				{{strtoupper($siswa->siswa->nama)}}
			</td>
			<td>
				@if($open)
				<select name="status[]" id="status" class="form-control">
					@if($siswa->rombongan_belajar->tingkat == 12)
					<option value="">== Pilih Status Kenaikan==</option>
					@else
					<option value="">== Pilih Status Kelulusan==</option>
					@endif
					@if($cari_tingkat_akhir)
					<option value="3"
						{{($siswa->kenaikan) ? ($siswa->kenaikan->status == 3) ? ' selected="selected"' : '' : ''}}>
						Lulus</option>
					<option value="4"
						{{($siswa->kenaikan) ? ($siswa->kenaikan->status == 4) ? ' selected="selected"' : '' : ''}}>
						Tidak Lulus</option>
					@else
					@if($siswa->rombongan_belajar->tingkat == 12)
					@if(in_array($siswa->rombongan_belajar_id, $rombel_4_tahun))
					<option value="1"
						{{($siswa->kenaikan) ? ($siswa->kenaikan->status == 1) ? ' selected="selected"' : '' : ''}}>Naik
						Ke Kelas</option>
					<option value="2"
						{{($siswa->kenaikan) ? ($siswa->kenaikan->status == 2) ? ' selected="selected"' : '' : ''}}>
						Tidak Naik</option>
					@else
					<option value="3"
						{{($siswa->kenaikan) ? ($siswa->kenaikan->status == 3) ? ' selected="selected"' : '' : ''}}>
						Lulus</option>
					<option value="4"
						{{($siswa->kenaikan) ? ($siswa->kenaikan->status == 4) ? ' selected="selected"' : '' : ''}}>
						Tidak Lulus</option>
					@endif
					@else
					<option value="1"
						{{($siswa->kenaikan) ? ($siswa->kenaikan->status == 1) ? ' selected="selected"' : '' : ''}}>Naik
						Ke Kelas</option>
					<option value="2"
						{{($siswa->kenaikan) ? ($siswa->kenaikan->status == 2) ? ' selected="selected"' : '' : ''}}>
						Tidak Naik</option>
					@endif
					@endif
				</select>
				@else
				@if($siswa->rombongan_belajar->tingkat == 12)
				{{
								($siswa->kenaikan) ? 
								($siswa->kenaikan->status == 3) ? 'Lulus' : 'Tidak Lulus'
								: 'Belum dilakukan proses kelulusan'
								}}
				@else
				{{
							($siswa->kenaikan) ? 
							($siswa->kenaikan->status == 1) ? 'Naik Kelas' : 'Tinggal Dikelas'
							: 'Belum dilakukan proses kenaikan'
							}}
				@endif
				@endif
			</td>
			<td>
				@if($open)
				<input type="hidden" class="form-control" name="rombongan_belajar[]" id="rombongan_belajar"
					value="{{($siswa->kenaikan) ? ($siswa->kenaikan->rombongan_belajar) ? $siswa->kenaikan->rombongan_belajar->rombongan_belajar_id : '' : ''}}" />
				<input type="text" class="form-control" id="nama_kelas" name="nama_kelas[]"
					value="{{($siswa->kenaikan) ? ($siswa->kenaikan->status == 1 && $siswa->kenaikan->rombongan_belajar || $siswa->kenaikan->status == 2 && $siswa->kenaikan->rombongan_belajar) ? $siswa->kenaikan->nama_kelas : '' : ''}}" />
				@else
				@if($siswa->kenaikan)
				{{$siswa->kenaikan->status}}
				@if($siswa->kenaikan->status == 1 && $siswa->kenaikan->rombongan_belajar || $siswa->kenaikan->status ==
				2 && $siswa->kenaikan->rombongan_belajar)
				{{$siswa->kenaikan->nama_kelas}}
				@endif
				@endif
				@endif
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
<script>
	$('select#status_salah').change(function(e) {
	e.preventDefault();
	var ini = $(this).val();
	var prev_td = $(this).closest('td').prev('td').find('input#kelas_sekarang').val();
	var next_td = $(this).closest('td').next('td').find('input');
	if(ini == 2){
		$(next_td).val(prev_td);
		//$(next_td).attr('disabled', 'disabled');
	} else {
		//$(next_td).removeAttr('disabled');
		$(next_td).val('');
	}
});
</script>
<script>
	$('select#status').change(function(e) {
		e.preventDefault();
		var ini = $(this).val();
		var ini_id = $(this);
		var kelas_sekarang = $(this).closest('td').prev('td').find('input#kelas_sekarang').val();
		var next_td_value = $(this).closest('td').next('td').find('input#rombongan_belajar');
		var nama_kelas = $(this).closest('td').next('td').find('input#nama_kelas');
		var rombongan_belajar_id = $(this).closest('td').prev('td').find('input#rombongan_belajar_id').val();
		if(ini == ''){
			return false;
		}
		console.log(ini);
		if(ini == 3 || ini == 4){
			$(next_td_value).val('');
			$(nama_kelas).val('');
		} else if(ini == 2){
			$(next_td_value).val(rombongan_belajar_id);
			$(nama_kelas).val(kelas_sekarang);
		} else {
			@if(in_array($siswa->rombongan_belajar_id, $rombel_4_tahun))
			$(nama_kelas).val(kelas_sekarang);
			$(next_td_value).val(rombongan_belajar_id);
			@else
			$.ajax({
				url: '{{route('ajax.get_next_rombel')}}',
				type: 'post',
				data: {_token:"{{ csrf_token() }}", rombongan_belajar_id:rombongan_belajar_id},
				success: function(data){
					var value = 'a';
					const select = document.createElement("select");
					const option = document.createElement("option");
					option.value = 'a';
					option.textContent = '== Pilih Rombongan Belajar ==';
					select.appendChild(option);
					$.each(data.rombongan_belajar, function(i, item){
						const option = document.createElement("option");
						option.value = i;
						option.textContent = item;
						select.appendChild(option);
					});
					select.onchange = function selectChanged(e) {
						value = e.target.value
					}
					swal({
						title: "Pilih Rombel",
						input: 'select',
						content: select,
						button: {
							text: "Pilih",
							closeModal: true,
						},
						closeOnClickOutside: false
					}).then(function() {
						if(value){
							console.log(value);
							return fetch('{{route('ajax.get_single_rombel')}}',{
								method: 'POST',
								headers: {
									"Content-Type": "application/json",
									"Accept": "application/json, text-plain, */*",
									"X-Requested-With": "XMLHttpRequest",
									"X-CSRF-TOKEN": "{{ csrf_token() }}"
								},
								credentials: "same-origin",
								body:JSON.stringify({rombongan_belajar_id: value})
							});
						} else {
							swal("Gagal!", "Rombongan Belajar tidak boleh kosong", "error").then(function(){
								$(ini_id).val('');
							});
						}
					}).then(results => {
						return results.json();
					}).then(result => {
						console.log(result);
						if(result.nama){
							$(next_td_value).val(result.rombongan_belajar_id);
							$(nama_kelas).val(result.nama);
							swal.stopLoading();
							swal.close();
						} else {
							swal("Gagal!", "Rombongan Belajar tidak boleh kosong", "error").then(function(){
								$(ini_id).val('');
							});
						}
					});
				}
			});
			@endif
		}
	});
</script>