<?php use Core\Helpers; ?>

<?php include('./app/Views/common/header.php'); ?>

<?php if (!$data['isAccessTable'] ) { ?>

    <form id="access-table-form" name="access-table-form" action="<?php echo Helpers::path('users/table'); ?>" method="POST">

        <?php if (!$data['isValidForm']) { ?>
            <div class="form-message text-center error">
                <?php echo $data['errorMessage']; ?>
            </div>
        <?php } ?>

        <div class="form-row text-center">
            <label for="password">Enter Admin Password (*):</label><br>
            <?php $fieldValue = $data['formData']['adminPassword']; ?>
            <?php $error = $data['formErrors']['adminErrors']['password']; ?>
            <?php $invalid = $error ? 'invalid' : ''; ?>
            <div class="error error-password <?php echo $error ? '' : 'hidden'; ?>">Should be valid password!</div>
            <input id="password" class="form-control <?php echo $invalid; ?>" type="password" name="adminPassword" value="<?php echo $fieldValue; ?>" placeholder="password" pattern=".{1,60}" data-error-target=".error-password">
        </div>
        <div class="form-row text-center">
            <input type="hidden" name="admin_name" value="admin">
            <button id="access-table-btn" class="form-control" type="submit" name="submit" value="accessTable">Submit</button>
        </div>
    </form>

<?php } else { ?>

<div class="filter">
    <form id="filter-users-form" name="filter-users-form" action="<?php echo Helpers::path(Helpers::getCurrentURI()); ?>" method="GET">
        <label>
            Select Race:
            <select name="race" id="races" class="form-control">
                <option value="">-- select race --</option>
                <?php foreach ($data['usersRaces'] as $race) { ?>
                    <option value="<?php echo $race; ?>" <?php echo ($race == $data['filterbyRace']) ? 'selected' : ''; ?>><?php echo $race; ?></option>
                <?php } ?>
                    <option value="other" <?php echo ($data['filterbyRace'] && !in_array($data['filterbyRace'], $data['usersRaces'])) ? 'selected' : ''; ?>>other</option>
            </select>
        </label>

        <br>
        <br>
        <label>
            Greater Than
            <input  class="form-control" type="number" name="mincrimes" value="<?php echo $data['filterbyMincrimes']; ?>" min="0" placeholder="num" pattern="[0-9]+">
            Crimes:
        </label>

        <br>
        <br>
        <label>
            With unpunished Crimes (is_punished = "NO"):
            <input  class="form-control" type="checkbox" name="unpunished" value="1" <?php echo $data['filterbyUnpunished'] ? 'checked' : ''; ?> >
        </label>

        <br>
        <br>
        <button class="form-control" type="submit" name="submit" value="filterby">Filter</button>
        <button class="form-control" type="reset" data-redirect-to="<?php echo Helpers::path('users/table'); ?>">Reset</button>
    </form>
</div>


<table>
    <thead>
        <tr>
            <th></th>
            <?php foreach($data['columnsMeta'] as $col) { ?>
                <th class="<?php echo $col['htmlClasses']; ?>">
                    <a <?php echo $col['orderbyUri'] ? 'href="' . $col['orderbyUri'] . '"' : ''; ?> >
                        <?php echo $col['columnName']; ?>
                    </a>
                    <span class="arrow"></span>
                </th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data['users'] as $user) { ?>
            <tr>
                <td><a href="<?php echo Helpers::path('users/delete/' . $user['id'] . '?' . 'redirect_to=' . Helpers::getCurrentURI()); ?>" class="delete-user">Delete</a></td>
                <?php foreach($user as $userColName => $userColVal) { ?>
                    <?php if (is_array($userColVal)) { ?>
                        <td>
                            <ul>
                                <?php foreach ($userColVal as $vals) { ?>
                                    <li>
                                        <ul>
                                            <?php foreach ($vals as $key => $val) { ?>
                                                <li>
                                                    <strong><?php echo $key; ?>:</strong>
                                                    <?php
                                                        echo ($key == 'is_punished') ? ($val == 1) ? 'YES' : 'NO' : $val;
                                                    ?>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li><hr>
                                <?php } ?>
                            </ul>
                        </td>
                    <?php } else { ?>
                        <td>
                            <?php
                                echo ($userColName == 'is_carriedring' || $userColName == 'is_enslaved') ? ($userColVal == 1) ? 'YES' : 'NO' : $userColVal;
                            ?>
                        </td>
                    <?php } ?>
                <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php } ?>

<?php include('./app/Views/common/footer.php'); ?>