<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลการปฏิบัติงาน</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">แก้ไขข้อมูลการปฏิบัติงาน</h2>
        
        <form action="{{ route('daily-tasks.update', $task->id) }}" method="POST" class="mb-5">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="type" class="form-label">ประเภทงาน</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="Development" {{ $task->type == 'Development' ? 'selected' : '' }}>Development</option>
                    <option value="Test" {{ $task->type == 'Test' ? 'selected' : '' }}>Test</option>
                    <option value="Document" {{ $task->type == 'Document' ? 'selected' : '' }}>Document</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">ชื่องานที่ดำเนินการ</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $task->name }}" required>
            </div>

            <div class="mb-3">
                <label for="start_time" class="form-label">เวลาที่เริ่มดำเนินการ</label>
                <input type="time" class="form-control" id="start_time" name="start_time" value="{{ $task->start_time }}" required>
            </div>

            <div class="mb-3">
                <label for="end_time" class="form-label">เวลาที่เสร็จสิ้น</label>
                <input type="time" class="form-control" id="end_time" name="end_time" value="{{ $task->end_time }}">
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">สถานะ</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>กำลังดำเนินการ</option>
                    <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>เสร็จสิ้น</option>
                    <option value="cancelled" {{ $task->status == 'cancelled' ? 'selected' : '' }}>ยกเลิก</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
            <a href="{{ route('daily-tasks.create') }}" class="btn btn-secondary">ยกเลิก</a>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>