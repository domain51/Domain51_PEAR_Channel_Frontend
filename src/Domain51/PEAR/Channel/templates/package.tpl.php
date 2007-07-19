<h2><?php echo $this->package; ?></h2>
<ul id="package">
    <?php if (count($this->releases) > 0) { ?>
    <li>
        <a href="<?php echo $this->index; ?>?package=<?php echo $this->package; ?>&amp;downloads">
            Download
        </a>
    </li>
    <li>
        <a href="<?php echo $this->index; ?>?package=<?php echo $this->package; ?>&amp;rss">
            RSS Feed
        </a>
    </li>
    <?php } ?>
    <?php echo $this->package_extras; ?>
</ul>

<?php
    if (isset($this->downloads)) {
        echo $this->downloads;
    } else {
?>
    <h3>Summary</h3>
    <p><?php echo nl2br($this->summary); ?></p>
    
    <h3>License</h3>
    <p>
    <?php if (isset($this->licenseuri)) { ?>
        <a href="<?php echo $this->licenseuri; ?>"><?php echo $this->license; ?></a>
    <?php } else { ?>
        <?php echo $this->license; ?>
    <?php } ?>
    
    <h3>Current Release</h3>
    <ul>
    <?php if (count($this->releases) == 0) { ?>
        <li>No releases have been made yet</li>
    <?php } else {
        foreach ($this->releases as $state => $release) {
            $release_uri = sprintf(
                'http://%s/get/%s-%s.tgz',
                $this->channel,
                $this->package,
                $release['version']
            );
    ?>
    
        <li>
            <a href="<?php echo $release_uri; ?>"><?php echo $release['version']; ?></a>
            (<?php echo $state; ?>) was released on <?php echo $release['date']; ?>
        </li>
        <?php } ?>
    <?php } ?>
    </ul>
    
    <?php if ($this->summary != $this->description) { ?>
    <h3>Description</h3>
    <p>
        <?php echo nl2br($this->description); ?>
    </p>
    <?php } ?>
    
    <?php if (count($this->devs) > 0) { ?>
    <h3>Maintainers</h3>
    <ul>
        <?php
            foreach ($this->devs as $dev) {
                $dev = $dev->toArray();
        ?>
        <li>
            <a href="<?php echo $this->index; ?>?user=<?php echo $dev['handle']; ?>">
                <?php echo (!empty($dev['name'])) ? $dev['name'] : $dev['handle']; ?>
            </a> (<?php echo ucfirst($dev['role']); ?>)
        </li>
        <?php } ?>
    </ul>
    <?php } ?>
    
    <?php if(!is_null($this->parent)) { ?>
    <h3>Parent Package</h3>
    <p>
        <a href="<?php echo $this->index; ?>?package=<?php echo $this->package; ?>">
            <?php echo $this->parent; ?>
        </a>
    </p>
    <?php } ?>
    
    <?php if (isset($this->subpackage)) { ?>
    <h3>Sub-Packages</h3>
    <ul>
    <?php while($this->subpackage->fetch()) { ?>
        <li>
            <a href="<?php echo $this->index; ?>?package=<?php echo $this->subpackage->package; ?>">
                <?php echo $this->subpackage->package; ?>
            </a>
        </li>
    <?php } ?>
    </ul>
    <?php } ?>
<?php } ?>