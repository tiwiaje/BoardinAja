<h2>Laporan Tugas</h2>
<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Status</th>
            <th>Deadline</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
        <tr>
            <td>{{ $task->title }}</td>
            <td>{{ $task->description }}</td>
            <td>{{ ucfirst($task->status) }}</td>
            <td>{{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->translatedFormat('d M Y') : '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
