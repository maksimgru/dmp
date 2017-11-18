<?php use Core\Helpers; ?>

<?php include('./app/Views/common/header.php'); ?>

<form id="add-user-form" name="add-user-form" action="<?php echo Helpers::path('users/add'); ?>" method="POST">

    <?php if ($data['newUserID'] && $data['isSubmitForm'] && $data['isValidForm'] ) { ?>


    <div class="form-message text-center success">
        Success!!! <br> Add new user with ID = <?php echo $data['newUserID']; ?>
    </div>
    <script>
        setTimeout(function () {
            window.location = "<?php echo Helpers::path('users/add'); ?>";
        }, 1000);
    </script>


    <?php } else { ?>


    <?php if (!$data['isValidForm']) { ?>
    <div class="form-message text-center error">
        <?php echo $data['errorMessage']; ?>
    </div>
    <?php } ?>


    <div class="form-row">
        <label for="name">Name (*):</label>
        <?php $fieldValue = $data['formData']['user']['name']; ?>
        <?php $error = $data['formErrors']['userErrors']['name']; ?>
        <?php $invalid = $error ? 'invalid' : ''; ?>
        <div class="error error-name <?php echo $error ? '' : 'hidden'; ?>">Should be min 1 and max 60 characters!</div>
        <input id="name" class="form-control <?php echo $invalid; ?>" type="text" name="user[name]" value="<?php echo $fieldValue; ?>" placeholder="text" pattern=".{1,60}" data-error-target=".error-name">
    </div>


    <div class="form-row">
        <label for="gender">Gender (*):</label>
        <?php $fieldValue = $data['formData']['user']['gender']; ?>
        <?php $error = $data['formErrors']['userErrors']['gender']; ?>
        <?php $invalid = $error ? 'invalid' : ''; ?>
        <?php $inArray = in_array(strtolower($fieldValue), $data['usersGenders']); ?>
        <div class="error error-gender <?php echo $error ? '' : 'hidden'; ?>">Should be min 1 and max 60 characters!</div>
        <select id="gender" class="form-control" name="user[gender]">
            <?php foreach ($data['usersGenders'] as $gender) { ?>
                <?php $selected = (strtolower($gender) == strtolower($fieldValue)) ? 'selected' : ''; ?>
                <option value="<?php echo $gender; ?>" <?php echo $selected; ?>><?php echo $gender; ?></option>
            <?php } ?>
            <?php $selected = $other = ''; ?>
            <?php
                if ($error || !$error && !$inArray && !empty($fieldValue)) {
                    $selected = 'selected';
                    $other = $fieldValue;
                }
            ?>
            <option class="other-value" data-value="other" value="<?php echo $other; ?>" <?php echo $selected; ?>>Other</option>
        </select>
        <input class="form-control gender-other other <?php echo $invalid; ?> <?php echo $selected ? '' : 'hidden'; ?>" type="text" name="" value="<?php echo $other; ?>" placeholder="text" pattern=".{1,60}" data-error-target=".error-gender">
    </div>


    <div class="form-row">
        <label for="race">Race (*):</label>
        <?php $fieldValue = $data['formData']['user']['race']; ?>
        <?php $error = $data['formErrors']['userErrors']['race']; ?>
        <?php $invalid = $error ? 'invalid' : ''; ?>
        <?php $inArray = in_array(strtolower($fieldValue), $data['usersRaces']); ?>
        <div class="error error-race <?php echo $error ? '' : 'hidden'; ?>">Should be min 1 and max 60 characters!</div>
        <select id="race" class="form-control" name="user[race]">
            <?php foreach ($data['usersRaces'] as $race) { ?>
                <?php $selected = (strtolower($race) == strtolower($fieldValue)) ? 'selected' : ''; ?>
                <option value="<?php echo $race; ?>" <?php echo $selected; ?>><?php echo $race; ?></option>
            <?php } ?>
            <?php $selected = $other = ''; ?>
            <?php
                if ($error || !$error && !$inArray && !empty($fieldValue)) {
                    $selected = 'selected';
                    $other = $fieldValue;
                }
            ?>
            <option class="other-value" data-value="other" value="<?php echo $other; ?>" <?php echo $selected; ?>>Other</option>
        </select>
        <input class="form-control race-other other <?php echo $invalid; ?> <?php echo $selected ? '' : 'hidden'; ?>" type="text" name="" value="<?php echo $other; ?>" placeholder="text" pattern=".{1,60}" data-error-target=".error-race">
    </div>


    <div class="form-row">
        <label for="placebirth">Place of Birth (*):</label>
        <?php $fieldValue = $data['formData']['user']['placebirth']; ?>
        <?php $error = $data['formErrors']['userErrors']['placebirth']; ?>
        <?php $invalid = $error ? 'invalid' : ''; ?>
        <?php $inArray = in_array($fieldValue, $data['usersPlacebirth']); ?>
        <div class="error error-placebirth <?php echo $error ? '' : 'hidden'; ?>">Should be min 1 and max 50 characters!</div>
        <select id="placebirth" class="form-control" name="user[placebirth]">
            <?php foreach ($data['usersPlacebirth'] as $placebirth) { ?>
                <?php $selected = (strtolower($placebirth) == strtolower($fieldValue)) ? 'selected' : ''; ?>
                <option value="<?php echo $placebirth; ?>" <?php echo $selected; ?>><?php echo $placebirth; ?></option>
            <?php } ?>
            <?php $selected = $other = ''; ?>
            <?php
                if ($error || !$error && !$inArray && !empty($fieldValue)) {
                    $selected = 'selected';
                    $other = $fieldValue;
                }
            ?>
            <option class="other-value" data-value="other" value="<?php echo $other; ?>" <?php echo $selected; ?>>Other</option>
        </select>
        <input class="form-control placebirth-other other <?php echo $invalid; ?> <?php echo $selected ? '' : 'hidden'; ?>" type="text" name="" value="<?php echo $other; ?>" placeholder="text" pattern=".{1,50}" data-error-target=".error-placebirth">
    </div>


    <div class="form-row">
        <label for="datebirth">Birthday yyyy-mm-dd (*):</label>
        <?php $fieldValue = $data['formData']['user']['datebirth']; ?>
        <?php $error = $data['formErrors']['userErrors']['datebirth']; ?>
        <?php $invalid = $error ? 'invalid' : ''; ?>
        <div class="error error-datebirth <?php echo $error ? '' : 'hidden'; ?>">Should be DATE string in format <strong>yyyy-mm-dd</strong></div>
        <input id="datebirth" class="form-control <?php echo $invalid; ?>" type="text" name="user[datebirth]" value="<?php echo $fieldValue; ?>" placeholder="yyyy-mm-dd" pattern="[0-9]{4}-[01][0-9]-[0-3][0-9]" data-error-target=".error-datebirth">
    </div>


    <div class="form-row">
        <label for="carriedring">Ever carried the ring?:</label>
        <?php $fieldValue = $data['formData']['user']['is_carriedring']; ?>
        <input id="carriedring" class="form-control" type="checkbox" name="user[is_carriedring]" value="1" <?php echo $fieldValue ? 'checked' : ''; ?>>
    </div>


    <div class="form-row">
        <label for="enslaved">Enslaved by Sauron:</label>
        <?php $fieldValue = $data['formData']['user']['is_enslaved']; ?>
        <input id="enslaved" class="form-control" type="checkbox" name="user[is_enslaved]" value="1" <?php echo $fieldValue ? 'checked' : ''; ?>>
    </div>


    <div class="form-row">
        <label for="crimes-notes">Crimes against Sauron:</label>
        <div class="crimes-item item template hidden">
            <label>Is Punished?
                <input class="form-control is-punished" type="checkbox" name="user[crimes][0][is_punished]" value="1" disabled data-default-val="1">
            </label>
            <div class="error error-crimes-date hidden">Should be DATE string in format <strong>yyyy-mm-dd</strong></div>
            <input class="form-control crimes-date" type="text" name="user[crimes][0][date]" value="<?php echo date('Y-m-d'); ?>" placeholder="yyyy-mm-dd" pattern="[0-9]{4}-[01][0-9]-[0-3][0-9]" disabled data-error-target=".error-crimes-date" data-default-val="<?php echo date('Y-m-d'); ?>">
            <div class="error error-crimes-note hidden">Should be min 1 and max 10000 characters!</div>
            <textarea class="form-control crimes-note" name="user[crimes][0][note]" placeholder="text" pattern=".{1,10000}" disabled data-error-target=".error-crimes-note" data-default-val=""></textarea>
            <button class="delete-item fr">delete</button>
        </div>
        <?php foreach ($data['formData']['user']['crimes'] as $indexCrime => $crime) { ?>
            <div class="crimes-item item">
                <label>Is Punished?
                    <input class="form-control is-punished" type="checkbox" name="user[crimes][<?php echo $indexCrime; ?>][is_punished]" value="1" <?php echo $crime['is_punished'] ? 'checked' : ''; ?> data-default-val="1">
                </label>
                <?php $error = $data['formErrors']['userErrors']['crimes'][$indexCrime]['date']; ?>
                <?php $invalid = $error ? 'invalid' : ''; ?>
                <div class="error error-crimes-date <?php echo $error ? '' : 'hidden'; ?>">Should be DATE string in format <strong>yyyy-mm-dd</strong></div>
                <input class="form-control crimes-date <?php echo $invalid; ?>" type="text" name="user[crimes][<?php echo $indexCrime; ?>][date]" value="<?php echo $crime['date']; ?>" placeholder="yyyy-mm-dd" pattern="[0-9]{4}-[01][0-9]-[0-3][0-9]" data-error-target=".error-crimes-date" data-default-val="<?php echo date('Y-m-d'); ?>">
                <?php $error = $data['formErrors']['userErrors']['crimes'][$indexCrime]['note']; ?>
                <?php $invalid = $error ? 'invalid' : ''; ?>
                <div class="error error-crimes-note <?php echo $error ? '' : 'hidden'; ?>">Should be min 1 and max 10000 characters!</div>
                <textarea class="form-control crimes-note <?php echo $invalid; ?>" name="user[crimes][<?php echo $indexCrime; ?>][note]" placeholder="text" pattern=".{1,10000}" data-error-target=".error-crimes-note" data-default-val=""><?php echo $crime['note']; ?></textarea>
                <button class="delete-item fr">delete</button>
            </div>
        <?php } ?>
        <button id="crimes-total" class="add-item" data-last-item-index="<?php echo isset($index_crime) ? $index_crime : 0;; ?>">+ add crimes</button>
    </div>


    <div class="form-row">
        <label for="notes">Notes:</label>
        <div class="notes-item item template hidden">
            <div class="error error-notes-date hidden">Should be DATE string in format <strong>yyyy-mm-dd</strong></div>
            <input class="form-control notes-date" type="text" name="user[notes][0][date]" value="<?php echo date('Y-m-d'); ?>" placeholder="yyyy-mm-dd" pattern="[0-9]{4}-[01][0-9]-[0-3][0-9]" disabled data-error-target=".error-notes-date" data-default-val="<?php echo date('Y-m-d'); ?>">
            <div class="error error-notes-note hidden" >Should be min 1 and max 10000 characters!</div>
            <textarea class="form-control notes-note" name="user[notes][0][note]" placeholder="text" pattern=".{1,10000}" disabled data-error-target=".error-notes-note" data-default-val=""></textarea>
            <button class="delete-item fr hidden">delete</button>
        </div>
        <?php foreach ($data['formData']['user']['notes'] as $indexNote => $note) { ?>
            <div class="crimes-item item">
                <?php $error = $data['formErrors']['userErrors']['notes'][$indexNote]['date']; ?>
                <?php $invalid = $error ? 'invalid' : ''; ?>
                <div class="error error-notes-date <?php echo $error ? '' : 'hidden'; ?>">Should be DATE string in format <strong>yyyy-mm-dd</strong></div>
                <input class="form-control notes-date <?php echo $invalid; ?>" type="text" name="user[notes][<?php echo $indexNote; ?>][date]" value="<?php echo $note['date']; ?>" placeholder="yyyy-mm-dd" pattern="[0-9]{4}-[01][0-9]-[0-3][0-9]" data-error-target=".error-notes-date" data-default-val="<?php echo date('Y-m-d'); ?>">
                <?php $error = $data['formErrors']['userErrors']['notes'][$indexNote]['note']; ?>
                <?php $invalid = $error ? 'invalid' : ''; ?>
                <div class="error error-notes-note <?php echo $error ? '' : 'hidden'; ?>">Should be min 1 and max 10000 characters!</div>
                <textarea class="form-control notes-note <?php echo $invalid; ?>" name="user[notes][<?php echo $indexNote; ?>][note]" placeholder="text" pattern=".{1,10000}" data-error-target=".error-notes-note" data-default-val=""><?php echo $note['note']; ?></textarea>
                <button class="delete-item fr">delete</button>
            </div>
        <?php } ?>
        <button id="crimes-total" class="add-item" data-last-item-index="<?php echo isset($indexNote) ? $indexNote : 0; ?>">+ add notes</button>
    </div>


        <div class="form-row">
            <label for="password">Admin Password (*):</label>
            <?php $fieldValue = $data['formData']['adminPassword']; ?>
            <?php $error = $data['formErrors']['adminErrors']['password']; ?>
            <?php $invalid = $error ? 'invalid' : ''; ?>
            <div class="error error-password <?php echo $error ? '' : 'hidden'; ?>">Should be valid password!</div>
            <input id="password" class="form-control <?php echo $invalid; ?>" type="password" name="adminPassword" value="<?php echo $fieldValue; ?>" placeholder="password" pattern=".{1,60}" data-error-target=".error-password">
        </div>


    <div class="form-row text-center">
        <button id="add-user-btn" class="form-control" type="submit" name="submit" value="addUser">Save</button>
    </div>
    <?php } ?>

</form>

<?php include('./app/Views/common/footer.php'); ?>