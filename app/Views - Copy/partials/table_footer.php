<?php
/**
 * Reusable Table Footer with Pagination
 * 
 * Expected variables:
 * - $baseUrl: Base URL for pagination links
 * - $currentPage: Current page number
 * - $totalPages: Total number of pages
 * - $limit: Records per page limit
 * - $totalRecords: Total number of records
 * - $search: Search query (optional)
 * - $tableId: ID for the table length selector (optional, defaults to 'table_length')
 * - $jsFunction: JavaScript function name for changing limit (optional, defaults to 'changeTableLimit')
 */

$tableId = $tableId ?? 'table_length';
$jsFunction = $jsFunction ?? 'changeTableLimit';
$search = $search ?? '';
$baseUrl = $baseUrl ?? '';
$currentPage = $currentPage ?? 1;
$totalPages = $totalPages ?? 1;
$limit = $limit ?? 10;
$totalRecords = $totalRecords ?? 0;
?>

<!--begin::Table Footer-->
<div class="row align-items-center py-3 border-top border-gray-200">
    <div class="col-sm-12 col-md-6">
        <div class="d-flex align-items-center">
            <label class="form-label fs-6 fw-semibold mb-0 me-2 text-gray-700">Show</label>
            <select class="form-select form-select-sm w-auto me-2" id="<?= $tableId ?>" onchange="<?= $jsFunction ?>(this.value)" style="min-width: 65px;">
                <option value="10" <?= $limit == 10 ? 'selected' : '' ?>>10</option>
                <option value="25" <?= $limit == 25 ? 'selected' : '' ?>>25</option>
                <option value="50" <?= $limit == 50 ? 'selected' : '' ?>>50</option>
                <option value="100" <?= $limit == 100 ? 'selected' : '' ?>>100</option>
            </select>
            <label class="form-label fs-6 fw-semibold mb-0 text-gray-700">entries</label>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="d-flex justify-content-end align-items-center">
            <div class="dataTables_info me-4" role="status" aria-live="polite">
                <span class="text-gray-700 fw-semibold fs-6">
                    Showing <?= (($currentPage - 1) * $limit) + 1 ?> to <?= min($currentPage * $limit, $totalRecords) ?> of <?= $totalRecords ?> entries
                </span>
            </div>
            <div class="dataTables_paginate">
                <ul class="pagination pagination-sm">
                    <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a href="<?= base_url($baseUrl . '?page=' . ($currentPage - 1) . ($search ? '&search=' . urlencode($search) : '') . '&limit=' . $limit) ?>" 
                           class="page-link" data-page="<?= $currentPage - 1 ?>" title="Previous">
                            <i class="ki-duotone ki-left fs-3"></i>
                        </a>
                    </li>
                    <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="ki-duotone ki-left fs-3"></i>
                        </span>
                    </li>
                    <?php endif; ?>
                    
                    <?php
                    // Calculate page range for display
                    $startPage = max(1, $currentPage - 1);
                    $endPage = min($totalPages, $currentPage + 1);
                    
                    // Adjust if we're at the beginning or end
                    if ($currentPage <= 2) {
                        $endPage = min($totalPages, 4);
                    }
                    if ($currentPage >= $totalPages - 1) {
                        $startPage = max(1, $totalPages - 3);
                    }
                    
                    for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                        <a href="<?= base_url($baseUrl . '?page=' . $i . ($search ? '&search=' . urlencode($search) : '') . '&limit=' . $limit) ?>" 
                           class="page-link" data-page="<?= $i ?>"><?= $i ?></a>
                    </li>
                    <?php endfor; ?>
                    
                    <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a href="<?= base_url($baseUrl . '?page=' . ($currentPage + 1) . ($search ? '&search=' . urlencode($search) : '') . '&limit=' . $limit) ?>" 
                           class="page-link" data-page="<?= $currentPage + 1 ?>" title="Next">
                            <i class="ki-duotone ki-right fs-3"></i>
                        </a>
                    </li>
                    <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="ki-duotone ki-right fs-3"></i>
                        </span>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--end::Table Footer-->