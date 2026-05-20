<?php 
// Memuat logika proses upload dan delete
require_once 'process.php'; 
// Memuat file konfigurasi direktori
require_once 'config.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Unggah & Galeri Foto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="upload-container">
        <h2>Unggah File Gambar</h2>

        <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="fileToUpload">Pilih file gambar:</label>
                <input type="file" name="fileToUpload" id="fileToUpload" required>
            </div>
            <input type="submit" value="Unggah File" name="submit">
        </form>
    </div>

    <h3 class="gallery-title">Isi Folder Upload</h3>
    <div class="gallery-grid">
        <?php
        // Mengambil berkas gambar berdasarkan konfigurasi folder di config.php
        $images = glob($target_dir . "*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}", GLOB_BRACE);

        if (count($images) > 0) {
            foreach ($images as $image) {
                $filename = basename($image);
                ?>
                <div class="gallery-item">
                    <img src="<?php echo $image; ?>" alt="<?php echo $filename; ?>" class="image-preview">
                    
                    <div class="file-info" title="<?php echo $filename; ?>">
                        <?php echo $filename; ?>
                    </div>
                    
                    <div class="action-buttons">
                        <a href="<?php echo $image; ?>" download class="btn btn-download">Unduh</a>
                        <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?action=delete&file=<?php echo urlencode($filename); ?>" 
                           onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?');" 
                           class="btn btn-delete">Hapus</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<div class="no-photos">Belum ada foto yang diunggah di folder "' . htmlspecialchars($target_dir) . '".</div>';
        }
        ?>
    </div>
</div>

</body>
</html>