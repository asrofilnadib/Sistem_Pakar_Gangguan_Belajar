<x-app-layout>
	<x-slot name="title">Member</x-slot>

	@if(session()->has('success'))
	<x-alert type="success" message="{{ session()->get('success') }}" />
	@endif
  <div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-danger">All Member</h6>
      <div>
        {{-- print user --}}
        <a href="#" target="_blank" class="btn btn-primary btn-sm">
          <i class="fas fa-print mr-1"></i> Print
        </a>
        <a href="{{ route('admin.member.create') }}" class="btn btn-success btn-sm">
          <i class="fas fa-plus"></i> Add Member
        </a>
      </div>
    </div>
    <div class="card-body">
      <table class="display responsive myTable" id="myTable">
        <thead>
        <tr>
          <th>Name</th>
          <th>Username</th>
          <th>Role</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @forelse($users as $user)
          <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->username }}</td>
            <td>
              @if(!empty($user->getRoleNames()))
                @foreach($user->getRoleNames() as $v)
                  <label class="badge badge-{{ ($v == 'Admin') ? 'danger' : 'primary' }}">{{ $v }}</label>
                @endforeach
              @endif
            </td>
            <td class="text-center">
              <button type="button" class="btn btn-info mr-1 info"
                      data-name="{{ $user->name }}"
                      data-username="{{ $user->username }}"
                      data-roles="{{ $user->getRoleNames() }}"
                      data-created="{{ $user->created_at->format('d-M-Y H:i:s') }}">
                <i class="fas fa-eye"></i>
              </button>
              <a href="{{ route('admin.member.edit', $user->id) }}" class="btn btn-primary mr-1">
                <i class="fas fa-edit"></i>
              </a>
              <form action="{{ route('admin.member.delete', $user->id) }}" method="POST" style="display: inline-block;">
                @csrf
                <button type="button" class="btn btn-danger delete">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="text-center">No Member</td>
          </tr>
        @endforelse
        </tbody>
      </table>
      <div class="mt-3">
        {{ $users->links() }}
      </div>
    </div>
  </div>

	<x-modal>
		<x-slot name="id">infoModal</x-slot>
		<x-slot name="title">Information</x-slot>

		<div class="row mb-2">
			<div class="col-6">
				<b>Name</b>
			</div>
			<div class="col-6" id="name-modal"></div>
		</div>
		<div class="row mb-2">
			<div class="col-6">
				<b>Username</b>
			</div>
			<div class="col-6" id="username-modal"></div>
		</div>
		<div class="row mb-2">
			<div class="col-6">
				<b>Roles</b>
			</div>
			<div class="col-6" id="roles-modal"></div>
		</div>
		<div class="row mb-2">
			<div class="col-6">
				<b>Created</b>
			</div>
			<div class="col-6" id="created-modal"></div>
		</div>
	</x-modal>

	<x-slot name="script">
    <script>
      $(document).ready(function () {
        let exportFormatter = {
          format: {
            body: function (data, row, column) {
              return column === 10 ? data.replace(/[$,]/g, '') : data;
            }
          }
        };

        const exportButton = [
          {extend: 'copyHtml5', title: 'copy'},
          {extend: 'csvHtml5', title: 'Data User Sistem Pakar SMP Islam'},
          {extend: 'excelHtml5', title: 'Data User Sistem Pakar SMP Islam'},
          // {extend: 'pdfHtml5', title: 'Data User Sistem Pakar SMP Islam'},
        ];

        const buttonConfig = exportButton.map(button => ({
          ...button,
          exportOptions: {
            columns: [0, 1, 2],
            format: exportFormatter,
          }
        }));

        $('#myTable').DataTable({
          responsive: true,
          layout: {
            topStart: {
              buttons: buttonConfig
            }
          },
          paging: true,
        });
      });
    </script>

		<script>
			$('.info').click(function(e) {
				e.preventDefault()

				$('#name-modal').text($(this).data('name'))
				$('#username-modal').text($(this).data('username'))
				$('#roles-modal').text($(this).data('roles'))
				$('#created-modal').text($(this).data('created'))

				$('#infoModal').modal('show')
			})

			$('.delete').click(function(e){
				e.preventDefault()
				const ok = confirm('Ingin menghapus user?')

				if(ok) {
					$(this).parent().submit()
				}
			})
		</script>
	</x-slot>
</x-app-layout>
