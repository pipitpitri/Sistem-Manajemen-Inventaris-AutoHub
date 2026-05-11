<?php
/** @var array $viewFile */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? APP_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 24px; font-size: 14px; color: #1f2937; }
        .print-toolbar { display: flex; justify-content: flex-end; margin-bottom: 16px; }
        .print-report { border: 1px solid #d1d5db; border-radius: 14px; padding: 24px; }
        .print-header { display: flex; justify-content: space-between; gap: 24px; align-items: flex-start; }
        .print-brand { display: flex; gap: 16px; align-items: center; }
        .print-brand img { width: 90px; height: auto; }
        .print-brand h1 { margin: 0 0 4px; font-size: 22px; }
        .print-brand p { margin: 0; color: #6b7280; }
        .print-meta { text-align: right; font-size: 13px; }
        .print-divider { border-top: 2px solid #111827; margin: 18px 0; }
        .print-table th { background: #eef2f7; }
        .print-table tfoot td { background: #f8fafc; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
            .print-report { border: none; padding: 0; }
        }
    </style>
</head>
<body>
    <?php require $viewFile; ?>
    <script>
        (() => {
            const returnUrl = <?= json_encode($returnUrl ?? route('reports')) ?>;
            let handled = false;

            const backToReport = () => {
                if (handled) {
                    return;
                }
                handled = true;

                try {
                    window.close();
                } catch (error) {
                }

                window.location.href = returnUrl;
            };

            window.addEventListener('afterprint', () => {
                setTimeout(backToReport, 150);
            });

            window.addEventListener('load', () => {
                setTimeout(() => {
                    window.print();
                    setTimeout(backToReport, 1200);
                }, 200);
            });
        })();
    </script>
</body>
</html>
