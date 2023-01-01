    <script src="assets/scripts/variables.js?v=<?= time() ?>"></script>
    <script src="assets/scripts/allRecords.js?v=<?= time() ?>"></script>
    <?php if(getActivePageName() == "records") : ?>
    <script src="assets/scripts/records.js?v=<?= time() ?>"></script>
    <?php elseif(getActivePageName() == "performance") : ?>
    <script src="assets/scripts/performance.js?v=<?= time() ?>"></script>
    <?php elseif(getActivePageName() == "weight") : ?>
    <script src="assets/scripts/weight.js?v=<?= time() ?>"></script>
    <?php endif; ?>
    <script src="assets/scripts/ham.js?v=<?= time() ?>"></script>