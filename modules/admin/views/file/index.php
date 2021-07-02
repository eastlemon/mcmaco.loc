<?php
use mihaildev\elfinder\ElFinder;
?>
<div class="file-index">
    <div class="box">
        <div class="box-body">
            <?= ElFinder::widget([
                'frameOptions' => ['style' => 'width: 100%; height: 640px; border: 0;']
            ]) ?>
        </div>
    </div>
</div>