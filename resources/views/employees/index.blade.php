@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center"
                style="background: #000 !important;">
                <h2 class="mb-0">{{ __('messages.employee_data') }}</h2>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <a href="{{ route('employees.create') }}" class="btn btn-info mb-4">
                        <i class="fas fa-plus"></i> {{ __('messages.add_employee') }}
                    </a>
                    <table class="table table-bordered table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th>{{ __('messages.photo') }}</th>
                                <th>{{ __('messages.name') }}</th>
                                <th>{{ __('messages.username') }}</th>
                                <th>{{ __('messages.email') }}</th>
                                <th>{{ __('messages.phone') }}</th>
                                <th>{{ __('messages.department') }}</th>
                                <th>{{ __('messages.position') }}</th>
                                <th>{{ __('messages.employment_status') }}</th>
                                <th>{{ __('messages.join_date') }}</th>
                                <th>{{ __('messages.end_work_date') }}</th>
                                <th>{{ __('messages.remaining_time') }}</th>
                                <th>{{ __('messages.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employees as $index => $employee)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="text-center">
                                        @if ($employee->profile_photo)
                                            <img src="{{ asset('storage/' . $employee->profile_photo) }}" alt="Foto Profil"
                                                class="rounded-circle"
                                                style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->username }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $employee->phone }}</td>
                                    <td>{{ $employee->departement }}</td>
                                    <td>{{ ucfirst($employee->position) ?? '-' }}</td>
                                    <td>{{ ucfirst($employee->employment_status) ?? '-' }}</td>
                                    <td>{{ $employee->join_date ? $employee->join_date->format('d/m/Y') : '-' }}</td>
                                    {{-- <td class="work-duration"
                                        data-join-date="{{ $employee->join_date ? $employee->join_date->format('Y-m-d') : '' }}">
                                        -</td>
                                    <td class="work-duration"
                                        data-join-date="{{ $employee->join_date ? $employee->join_date->format('Y-m-d') : '' }}">
                                        -</td>
                                    <td class="work-duration"
                                        data-join-date="{{ $employee->join_date ? $employee->join_date->format('Y-m-d') : '' }}">
                                        -</td> --}}

                                    {{-- <td class="work-duration"
                                        data-join-date="{{ $employee->join_date ? $employee->join_date->format('Y-m-d') : '' }}">
                                        -
                                    </td> --}}
                                    <td class="end-date"
                                        data-join-date="{{ $employee->join_date ? $employee->join_date->format('Y-m-d') : '' }}"
                                        data-duration="{{ $employee->contract_duration ?? '' }}">
                                        -
                                    </td>
                                    <td class="remaining-days"
                                        data-join-date="{{ $employee->join_date ? $employee->join_date->format('Y-m-d') : '' }}"
                                        data-duration="{{ $employee->contract_duration ?? '' }}">
                                        -
                                    </td>


                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('employees.show', $employee->id) }}"
                                                class="btn btn-info btn-sm" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>&nbsp;
                                            <a href="{{ route('employees.edit', $employee->id) }}"
                                                class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>&nbsp;
                                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">{{ __('messages.no_employee_data') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $employees->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection



@push('scripts')
    <script>
        function calculateWorkDuration() {
            const durationCells = document.querySelectorAll('.work-duration');
            durationCells.forEach(cell => {
                const joinDateStr = cell.dataset.joinDate;
                if (joinDateStr) {
                    const joinDate = new Date(joinDateStr);
                    const now = new Date();

                    let years = now.getFullYear() - joinDate.getFullYear();
                    let months = now.getMonth() - joinDate.getMonth();
                    let days = now.getDate() - joinDate.getDate();

                    if (days < 0) {
                        months--;
                        const prevMonth = new Date(now.getFullYear(), now.getMonth(), 0);
                        days += prevMonth.getDate();
                    }

                    if (months < 0) {
                        years--;
                        months += 12;
                    }

                    let result = '';
                    if (years > 0) result += `${years} tahun `;
                    if (months > 0) result += `${months} bulan `;
                    result += `${days} hari`;
                    cell.textContent = result.trim();
                }
            });
        }

        function calculateEndDates() {
            const endDateCells = document.querySelectorAll('.end-date');
            endDateCells.forEach(cell => {
                const joinDateStr = cell.dataset.joinDate;
                const durationMonths = parseInt(cell.dataset.duration);
                if (joinDateStr && durationMonths) {
                    const joinDate = new Date(joinDateStr);
                    const endDate = new Date(joinDate);
                    endDate.setMonth(endDate.getMonth() + durationMonths);

                    const formatted =
                        `${endDate.getDate().toString().padStart(2, '0')}/${(endDate.getMonth() + 1).toString().padStart(2, '0')}/${endDate.getFullYear()}`;
                    cell.textContent = formatted;
                }
            });
        }

        function calculateRemainingDays() {
            const remainingCells = document.querySelectorAll('.remaining-days');
            remainingCells.forEach(cell => {
                const joinDateStr = cell.dataset.joinDate;
                const durationMonths = parseInt(cell.dataset.duration);
                if (joinDateStr && durationMonths) {
                    const joinDate = new Date(joinDateStr);
                    const endDate = new Date(joinDate);
                    endDate.setMonth(endDate.getMonth() + durationMonths);

                    const now = new Date();
                    const diff = endDate - now;
                    const daysLeft = Math.ceil(diff / (1000 * 60 * 60 * 24));
                    cell.textContent = daysLeft > 0 ? `${daysLeft} hari` : 'Kontrak berakhir';
                }
            });
        }

        function updateAll() {
            calculateWorkDuration();
            calculateEndDates();
            calculateRemainingDays();
        }

        document.addEventListener('DOMContentLoaded', updateAll);
        setInterval(updateAll, 60000);
    </script>
@endpush
