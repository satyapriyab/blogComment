<?php

	$result = $blogobj->findData("blogComment", "recordId", 2);
    $records = $result->getRecords();
	$maxRecords = $result->getFoundSetCount();
    $recordsCount = 0;
    ?>