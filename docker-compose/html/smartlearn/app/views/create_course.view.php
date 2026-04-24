<form action="add-course" method="post" class="form-grid">

       <label for="name">Nom du cours:</label>
       <input type="text" id="name" name="name"
              value="<?= Helper::e($old['name'] ?? '') ?>">

       <label for="descriptive">Descriptif:</label>
       <textarea id="descriptive" name="descriptive" rows="3"><?= Helper::e($old['descriptive'] ?? '') ?></textarea>

       <label for="delay">Délai d'inscription:</label>
       <input type="date" id="delay" name="delay"
              value="<?= Helper::e($old['delay'] ?? '') ?>">

       <label for="date_start">Date de début:</label>
       <input type="date" id="date_start" name="date_start"
              value="<?= Helper::e($old['date_start'] ?? '') ?>">

       <label for="date_end">Date de fin:</label>
       <input type="date" id="date_end" name="date_end"
              value="<?= Helper::e($old['date_end'] ?? '') ?>">

       <label for="time_start">Horaire de début:</label>
       <input type="time" id="time_start" name="time_start"
              value="<?= Helper::e($old['time_start'] ?? '') ?>">

       <label for="time_end">Horaire de fin:</label>
       <input type="time" id="time_end" name="time_end"
              value="<?= Helper::e($old['time_end'] ?? '') ?>">

        <label for="days">Jour(s):</label>
        <fieldset>
              <?php
              $selectedDays = $old['days'] ?? [];
              ?>

              <label>
                     <input type="checkbox" name="days[]" value="Lundi"
                     <?= in_array('Lundi', $selectedDays) ? 'checked' : '' ?>>
                     Lundi
              </label>

              <label>
                     <input type="checkbox" name="days[]" value="Mardi"
                     <?= in_array('Mardi', $selectedDays) ? 'checked' : '' ?>>
                     Mardi
              </label>

              <label>
                     <input type="checkbox" name="days[]" value="Mercredi"
                     <?= in_array('Mercredi', $selectedDays) ? 'checked' : '' ?>>
                     Mercredi
              </label>

              <label>
                     <input type="checkbox" name="days[]" value="Jeudi"
                     <?= in_array('Jeudi', $selectedDays) ? 'checked' : '' ?>>
                     Jeudi
              </label>

              <label>
                     <input type="checkbox" name="days[]" value="Vendredi"
                     <?= in_array('Vendredi', $selectedDays) ? 'checked' : '' ?>>
                     Vendredi
              </label>

              <label>
                     <input type="checkbox" name="days[]" value="Samedi"
                     <?= in_array('Samedi', $selectedDays) ? 'checked' : '' ?>>
                     Samedi
              </label>
       </fieldset>

       <label for="period">Périodes:</label>
       <input type="number" id="period" name="period" step="1"
              value="<?= Helper::e($old['period'] ?? '') ?>">

       <label for="sites">Lieux:</label>
       <input type="text" id="sites" name="sites"
              value="<?= Helper::e($old['sites'] ?? '') ?>">

       <label for="price">Prix:</label>
       <div class="prix-wrapper">
       <input type="number" id="price" name="price" step="1"
              value="<?= Helper::e($old['price'] ?? '') ?>">
       <span class="prix-unit">CHF</span>
       </div>

       <input type="submit" name="createCourse" value="Créer" class="submit-btn">

</form>

<?php if (!empty($message)): ?>
       <div class="alert alert-<?= $type ?>">
       <?= Helper::e($message) ?>
       </div>
<?php endif; ?>