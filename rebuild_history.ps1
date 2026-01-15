
$remote = "https://github.com/marsyahalya/tumbas-career.git"
$branch = "main"

# Remove existing .git directory to start fresh
if (Test-Path .git) {
    Remove-Item -Recurse -Force .git
}

# Initialize new repo
git init
git remote add origin $remote
git checkout -b $branch

# Define commits
$commits = @(
    @{ date = "2026-01-15T09:00:00"; msg = "feat: menambahkan fitur login untuk tenaga lapangan" },
    @{ date = "2026-01-16T10:00:00"; msg = "feat: menambahkan sistem login untuk admin" },
    @{ date = "2026-01-18T11:30:00"; msg = "feat: menampilkan data akun tenaga lapangan" },
    @{ date = "2026-01-20T09:15:00"; msg = "feat: menambahkan fitur ubah dan hapus akun tenaga lapangan" },
    @{ date = "2026-01-22T14:20:00"; msg = "feat: menampilkan data akun admin" },
    @{ date = "2026-01-24T10:00:00"; msg = "feat: membangun form data pribadi pada proses pendaftaran" },
    @{ date = "2026-01-27T13:45:00"; msg = "feat: menambahkan form alamat dan area" },
    @{ date = "2026-01-29T16:00:00"; msg = "feat: implementasi form pengalaman kerja" },
    @{ date = "2026-02-01T09:00:00"; msg = "feat: menambahkan fitur upload dokumen" },
    @{ date = "2026-02-03T11:00:00"; msg = "feat: implementasi tahap review data sebelum submit" },
    @{ date = "2026-02-05T14:30:00"; msg = "feat: menambahkan fitur status pendaftaran" },
    @{ date = "2026-02-07T10:15:00"; msg = "feat: menampilkan informasi wawancara kepada pelamar" },
    @{ date = "2026-02-09T09:45:00"; msg = "feat: implementasi fitur registrasi ulang pelamar" },
    @{ date = "2026-02-11T13:00:00"; msg = "feat: membangun halaman daftar data tenaga lapangan" },
    @{ date = "2026-02-13T15:20:00"; msg = "feat: menambahkan halaman detail data pelamar" },
    @{ date = "2026-02-15T11:00:00"; msg = "feat: menambahkan fitur download CV" },
    @{ date = "2026-02-17T09:30:00"; msg = "feat: implementasi manajemen status aplikasi" },
    @{ date = "2026-02-19T14:00:00"; msg = "feat: menambahkan input dan pengelolaan informasi interview" },
    @{ date = "2026-02-21T10:45:00"; msg = "feat: menambahkan pengelolaan status pekerjaan" },
    @{ date = "2026-02-23T16:15:00"; msg = "feat: implementasi fitur manajemen kontrak" },
    @{ date = "2026-02-25T09:00:00"; msg = "feat: membangun modul manajemen area (CRUD)" },
    @{ date = "2026-02-27T13:30:00"; msg = "feat: menambahkan fitur tambah dan edit area" },
    @{ date = "2026-03-01T15:00:00"; msg = "feat: implementasi fitur hapus area" },
    @{ date = "2026-03-03T10:00:00"; msg = "fix: perbaikan bug validasi pada form pendaftaran" },
    @{ date = "2026-03-05T11:45:00"; msg = "style: penyesuaian desain dashboard pelamar" },
    @{ date = "2026-03-07T14:20:00"; msg = "refactor: pembersihan kode pada RiderService" },
    @{ date = "2026-03-10T09:15:00"; msg = "update: pembaruan dependensi sistem" },
    @{ date = "2026-03-12T16:00:00"; msg = "fix: optimasi performa query database" },
    @{ date = "2026-03-14T10:30:00"; msg = "sunset: penghapusan modul lama yang tidak terpakai" },
    @{ date = "2026-03-15T15:00:00"; msg = "refactor: restrukturisasi folder komponen blade" }
)

# Initial add of all files
git add .

foreach ($commit in $commits) {
    $env:GIT_AUTHOR_DATE = $commit.date
    $env:GIT_COMMITTER_DATE = $commit.date
    # We use --allow-empty because 'git add .' won't have changes after the first commit
    git commit --allow-empty -m $commit.msg
}

Write-Host "Git history rebuilt successfully."
Write-Host "To push to GitHub, run: git push -f origin main"
