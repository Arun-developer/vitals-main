
<ul class="tabs">
    <li class="<?php echo($this->uri->segment('3') == 'useraccess') ? 'selected' : ''; ?>"><a href="<?= site_url('mainmaster/useraccess/index') ?>" >Add User Access</a></li>
    <li class="<?php echo($this->uri->segment('3') == 'addgroup') ? 'selected' : ''; ?>"><a href="<?= site_url('mainmaster/useraccess/adduser') ?>">Add User Group</a></li>
    <li class="<?php echo($this->uri->segment('3') == 'addadmin') ? 'selected' : ''; ?>"><a href="<?= site_url('mainmaster/useraccess/addadmin') ?>">Add Admin</a></li>
    <li class="<?php echo($this->uri->segment('3') == 'addincubatee') ? 'selected' : ''; ?>"><a href="<?= site_url('mainmaster/useraccess/addincubatee') ?>">Manage Incubatee</a></li>
</ul>

<h1><?= $cpagetitle; ?></h1>
<table class="gtable">
    <thead>
        <tr>
            <th>
                id
            </th>
            <th>Name</th>
            <th>Name of the Incubatee</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($incuabteeusers as $row): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><a href="<?= site_url('mainmaster/useraccess/editincubatee/' . $row['innovation']); ?>"><?= $row['user_name']; ?></a></td>
                <td><?= $row['name_of_enterprise']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
