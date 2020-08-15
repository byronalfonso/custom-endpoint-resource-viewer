<?php
  $selectedResource = esc_attr(get_option('resource_select'));
  $availableResources = ["users", "posts", "photos"];
?>

<select name="resource_select" id="resource">  
  <?php foreach ($availableResources as $resource) { ?>
    <option 
      value="<?php echo $resource?>"
      <?php echo ($resource == $selectedResource) ? "selected" : "" ?>
    >
      <?php echo ucfirst($resource)?>
    </option>
  <?php } ?>
</select>