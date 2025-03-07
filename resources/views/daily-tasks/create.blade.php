<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บันทึกการปฏิบัติงานประจำวัน</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <!-- แสดงข้อความแจ้งเตือนเมื่อบันทึกสำเร็จ -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="mb-4">บันทึกการปฏิบัติงานประจำวัน</h2>
        
        <form action="{{ route('daily-tasks.store') }}" method="POST" class="mb-5">
            @csrf
            
            <div class="mb-3">
                <label for="type" class="form-label">ประเภทงาน</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="">เลือกประเภทงาน</option>
                    <option value="Development">Development</option>
                    <option value="Test">Test</option>
                    <option value="Document">Document</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">ชื่องานที่ดำเนินการ</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="start_time" class="form-label">วันและเวลาที่เริ่มดำเนินการ</label>
                <input type="datetime-local" class="form-control" id="start_time" name="start_time" required>
            </div>

            <div class="mb-3">
                <label for="end_time" class="form-label">วันและเวลาที่เสร็จสิ้น</label>
                <input type="datetime-local" class="form-control" id="end_time" name="end_time">
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">สถานะ</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="in_progress">กำลังดำเนินการ</option>
                    <option value="completed">เสร็จสิ้น</option>
                    <option value="cancelled">ยกเลิก</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
        </form>

        <div class="card mt-4 mb-4">
            <div class="card-body">
                <h5 class="mb-3">ค้นหาข้อมูล</h5>
                
                <form action="{{ route('daily-tasks.create') }}" method="GET" class="row g-3 align-items-end mb-3">
                    <div class="col-md-4">
                        <label for="search_date" class="form-label">ค้นหาตามวันที่</label>
                        <input type="date" class="form-control" id="search_date" name="search_date" value="{{ request('search_date') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary me-2">ค้นหา</button>
                        @if(request('search_date'))
                            <a href="{{ route('daily-tasks.create') }}" class="btn btn-secondary">ล้าง</a>
                        @endif
                    </div>
                </form>

                <hr>

                <form action="{{ route('daily-tasks.create') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="search_month" class="form-label">เดือน</label>
                        <select class="form-select" id="search_month" name="search_month">
                            <option value="">เลือกเดือน</option>
                            @php
                                $thaiMonths = [
                                    1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม',
                                    4 => 'เมษายน', 5 => 'พฤษภาคม', 6 => 'มิถุนายน',
                                    7 => 'กรกฎาคม', 8 => 'สิงหาคม', 9 => 'กันยายน',
                                    10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
                                ];
                            @endphp
                            @foreach($thaiMonths as $value => $month)
                                <option value="{{ $value }}" {{ request('search_month') == $value ? 'selected' : '' }}>{{ $month }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="search_year" class="form-label">ปี</label>
                        <select class="form-select" id="search_year" name="search_year">
                            <option value="">เลือกปี</option>
                            @for($year = date('Y'); $year >= date('Y')-5; $year--)
                                <option value="{{ $year }}" {{ request('search_year') == $year ? 'selected' : '' }}>{{ $year + 543 }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary me-2">ค้นหา</button>
                        @if(request('search_month') || request('search_year'))
                            <a href="{{ route('daily-tasks.create') }}" class="btn btn-secondary">ล้าง</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <h3 class="mb-4">รายการที่บันทึก</h3>

        @if($statusSummary)
        <div class="row mb-4">
            <div class="col">
                <div class="alert alert-info">
                    <h5 class="alert-heading">สรุปสถานะประจำเดือน {{ $thaiMonths[$statusSummary['month']] }} {{ $statusSummary['year'] + 543 }}</h5>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="card bg-warning text-white h-100">
                                <div class="card-body text-center">
                                    <h6 class="card-title">กำลังดำเนินการ</h6>
                                    <h2 class="mb-0">{{ $statusSummary['in_progress'] }}</h2>
                                    <small>รายการ</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white h-100">
                                <div class="card-body text-center">
                                    <h6 class="card-title">เสร็จสิ้น</h6>
                                    <h2 class="mb-0">{{ $statusSummary['completed'] }}</h2>
                                    <small>รายการ</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white h-100">
                                <div class="card-body text-center">
                                    <h6 class="card-title">ยกเลิก</h6>
                                    <h2 class="mb-0">{{ $statusSummary['cancelled'] }}</h2>
                                    <small>รายการ</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-primary text-white h-100">
                                <div class="card-body text-center">
                                    <h6 class="card-title">รวมทั้งหมด</h6>
                                    <h2 class="mb-0">{{ $statusSummary['total'] }}</h2>
                                    <small>รายการ</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ลำดับ</th>
                        <th>ประเภทงาน</th>
                        <th>ชื่องาน</th>
                        <th>เวลาเริ่ม</th>
                        <th>เวลาสิ้นสุด</th>
                        <th>สถานะ</th>
                        <th>วันที่บันทึก</th>
                        <th>การจัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $index => $task)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $task->type }}</td>
                        <td>{{ $task->name }}</td>
                        <td>{{ date('d/m/Y H:i', strtotime($task->start_time)) }}</td>
                        <td>{{ $task->end_time ? date('d/m/Y H:i', strtotime($task->end_time)) : '-' }}</td>
                        <td>
                            @switch($task->status)
                                @case('in_progress')
                                    <span class="badge bg-warning">กำลังดำเนินการ</span>
                                    @break
                                @case('completed')
                                    <span class="badge bg-success">เสร็จสิ้น</span>
                                    @break
                                @case('cancelled')
                                    <span class="badge bg-danger">ยกเลิก</span>
                                    @break
                            @endswitch
                        </td>
                        <td>{{ $task->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('daily-tasks.edit', $task->id) }}" class="btn btn-sm btn-warning">แก้ไข</a>
                            <form action="{{ route('daily-tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('ยืนยันการลบข้อมูล?')">ลบ</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 