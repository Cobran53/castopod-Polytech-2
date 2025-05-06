<?php declare(strict_types=1);

?>

<?= $this->extend('_layout') ?>

<?= $this->section('title') ?>
<?= lang('Podcast.create') ?>
<?= $this->endSection() ?>

<?= $this->section('pageTitle') ?>
<?= lang('Podcast.create') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" integrity="sha512-zxBiDORGDEAYDdKLuYU9X/JaJo/DPzE42UubfBw9yg8Qvb2YRRIQ8v4KsGHOx2H1/+sdSXyXxLXv5r7tHc9ygg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div id="all">

<form id="podcast-form" action="<?= route_to('podcast-create') ?>" method="POST" enctype='multipart/form-data' class="flex flex-col w-full max-w-xl gap-y-6">
<?= csrf_field() ?>

<Forms.Section
    title="<?= lang('Podcast.form.identity_section_title') ?>"
    subtitle="<?= lang('Podcast.form.identity_section_subtitle') ?>" >

<Forms.Field
    name="cover"
    label="<?= esc(lang('Podcast.form.cover')) ?>"
    helper="<?= esc(lang('Podcast.form.cover_size_hint')) ?>"
    type="file"
    required="true"
    accept=".jpg,.jpeg,.png" />

<div id="imagePreview" class="hidden"></div>

<Forms.Field
    name="title"
    label="<?= esc(lang('Podcast.form.title')) ?>"
    required="true" />

<Forms.Field
    as="MarkdownEditor"
    name="description"
    label="<?= esc(lang('Podcast.form.description')) ?>"
    required="true"
    disallowList="header,quote" />

<fieldset>
    <legend><?= lang('Podcast.form.type.label') ?></legend>
    <div class="flex gap-2">
        <Forms.RadioButton
            value="episodic"
            name="type"
            hint="<?= esc(lang('Podcast.form.type.episodic_hint')) ?>"
            isChecked="true'" ><?= lang('Podcast.form.type.episodic') ?></Forms.RadioButton>
        <Forms.RadioButton
            value="serial"
            name="type"
            hint="<?= esc(lang('Podcast.form.type.serial_hint')) ?>"
            isChecked="false" ><?= lang('Podcast.form.type.serial') ?></Forms.RadioButton>
    </div>
</fieldset>
<fieldset>
    <legend><?= lang('Podcast.form.medium.label') ?></legend>
    <div class="flex gap-2">
        <Forms.RadioButton
            value="podcast"
            name="medium"
            hint="<?= esc(lang('Podcast.form.medium.podcast_hint')) ?>"
            isChecked="true" ><?= lang('Podcast.form.medium.podcast') ?></Forms.RadioButton>
        <Forms.RadioButton
            value="music"
            name="medium"
            hint="<?= esc(lang('Podcast.form.medium.music_hint')) ?>"
            isChecked="false" ><?= lang('Podcast.form.medium.music') ?></Forms.RadioButton>
        <Forms.RadioButton
            value="audiobook"
            name="medium"
            hint="<?= esc(lang('Podcast.form.medium.audiobook_hint')) ?>"
            isChecked="false" ><?= lang('Podcast.form.medium.audiobook') ?></Forms.RadioButton>
    </div>
</fieldset>
</Forms.Section>

<Forms.Section
    title="<?= lang('Podcast.form.classification_section_title') ?>"
    subtitle="<?= lang('Podcast.form.classification_section_subtitle') ?>" >

    <Forms.Field
        as="Select"
        name="language"
        label="<?= esc(lang('Podcast.form.language')) ?>"
        selected="<?= $browserLang ?>"
        required="true"
        options="<?= esc(json_encode($languageOptions)) ?>" />

    <Forms.Field
        as="Select"
        name="category"
        label="<?= esc(lang('Podcast.form.category')) ?>"
        required="true"
        options="<?= esc(json_encode($categoryOptions)) ?>" />

    <Forms.Field
        as="MultiSelect"
        name="other_categories[]"
        label="<?= esc(lang('Podcast.form.other_categories')) ?>"
        data-max-item-count="2"
        options="<?= esc(json_encode($categoryOptions)) ?>" />

    <fieldset class="mb-4">
        <legend><?= lang('Podcast.form.parental_advisory.label') .
                    hint_tooltip(lang('Podcast.form.parental_advisory.hint'), 'ml-1') ?></legend>
        <div class="flex gap-2">
            <Forms.RadioButton
                value="undefined"
                name="parental_advisory"
                isChecked="true" ><?= lang('Podcast.form.parental_advisory.undefined') ?></Forms.RadioButton>
            <Forms.RadioButton
                value="clean"
                name="parental_advisory"
                isChecked="false" ><?= lang('Podcast.form.parental_advisory.clean') ?></Forms.RadioButton>
            <Forms.RadioButton
                value="explicit"
                name="parental_advisory"
                isChecked="false" ><?= lang('Podcast.form.parental_advisory.explicit') ?></Forms.RadioButton>
        </div>
    </fieldset>
</Forms.Section>

<Forms.Section
    title="<?= lang('Podcast.form.author_section_title') ?>"
    subtitle="<?= lang('Podcast.form.author_section_subtitle') ?>" >

<Forms.Field
    name="owner_name"
    label="<?= esc(lang('Podcast.form.owner_name')) ?>"
    hint="<?= esc(lang('Podcast.form.owner_name_hint')) ?>"
    required="true" />

<Forms.Field
    name="owner_email"
    type="email"
    label="<?= esc(lang('Podcast.form.owner_email')) ?>"
    hint="<?= esc(lang('Podcast.form.owner_email_hint')) ?>"
    required="true" />

<Forms.Toggler class="mt-2" name="is_owner_email_removed_from_feed" value="yes" checked="true" hint="<?= esc(lang('Podcast.form.is_owner_email_removed_from_feed_hint')) ?>">
    <?= lang('Podcast.form.is_owner_email_removed_from_feed') ?></Forms.Toggler>

<Forms.Field
    name="publisher"
    label="<?= esc(lang('Podcast.form.publisher')) ?>"
    hint="<?= esc(lang('Podcast.form.publisher_hint')) ?>" />

<Forms.Field
    name="copyright"
    label="<?= esc(lang('Podcast.form.copyright')) ?>" />

</Forms.Section>

<Forms.Section
    title="<?= lang('Podcast.form.fediverse_section_title') ?>" >
    
    <div class="flex flex-col">
        <Forms.Label for="handle" hint="<?= esc(lang('Podcast.form.handle_hint')) ?>"><?= lang('Podcast.form.handle') ?></Forms.Label>
        <div class="relative">
            <?= icon('at-line', [
                'class' => 'absolute inset-0 h-full text-xl opacity-40 left-3',
            ]) ?>
            <Forms.Input name="handle" class="w-full pl-8" required="true" />
        </div>
    </div>

    <Forms.Field
        name="banner"
        label="<?= esc(lang('Podcast.form.banner')) ?>"
        helper="<?= esc(lang('Podcast.form.banner_size_hint')) ?>"
        type="file"
        accept=".jpg,.jpeg,.png" />
</Forms.Section>

<Forms.Section title="<?= lang('Podcast.form.premium') ?>">
    <Forms.Toggler class="mt-2" name="premium_by_default" value="yes" checked="false" hint="<?= esc(lang('Podcast.form.premium_by_default_hint')) ?>">
        <?= lang('Podcast.form.premium_by_default') ?></Forms.Toggler>
</Forms.Section>

<Forms.Section
    title="<?= lang('Podcast.form.op3') ?>"
    subtitle="<?= lang('Podcast.form.op3_hint') ?>">

    <a href="https://op3.dev" target="_blank" rel="noopener noreferrer" class="inline-flex self-start text-xs font-semibold underline gap-x-1 text-skin-muted hover:no-underline focus:ring-accent"><?= icon('link', [
        'class' => 'text-sm',
    ]) ?>op3.dev</a>
    <Forms.Toggler name="enable_op3" value="yes" checked="false" hint="<?= esc(lang('Podcast.form.op3_enable_hint')) ?>"><?= lang('Podcast.form.op3_enable') ?></Forms.Toggler>
</Forms.Section>

<Forms.Section
    title="<?= lang('Podcast.form.location_section_title') ?>"
    subtitle="<?= lang('Podcast.form.location_section_subtitle') ?>" >

<Forms.Field
    name="location_name"
    label="<?= esc(lang('Podcast.form.location_name')) ?>"
    hint="<?= esc(lang('Podcast.form.location_name_hint')) ?>" />

</Forms.Section>

<Forms.Section
    title="<?= lang('Podcast.form.advanced_section_title') ?>" >

<Forms.Field
    as="XMLEditor"
    name="custom_rss"
    label="<?= esc(lang('Podcast.form.custom_rss')) ?>"
    hint="<?= esc(lang('Podcast.form.custom_rss_hint')) ?>"
    rows="8" />

<Forms.Field
    as="Textarea"
    name="verify_txt"
    label="<?= esc(lang('Podcast.form.verify_txt')) ?>"
    hint="<?= esc(lang('Podcast.form.verify_txt_hint')) ?>"
    helper="<?= esc(lang('Podcast.form.verify_txt_helper')) ?>"
    rows="5" />

<Forms.Toggler class="mb-2" name="lock" value="yes" checked="true" hint="<?= esc(lang('Podcast.form.lock_hint')) ?>">
    <?= lang('Podcast.form.lock') ?>
</Forms.Toggler>
<Forms.Toggler class="mb-2" name="block" value="yes" checked="false" hint="<?= esc(lang('Podcast.form.block_hint')) ?>">
    <?= lang('Podcast.form.block') ?>
</Forms.Toggler>
<Forms.Toggler name="complete" value="yes" checked="false">
    <?= lang('Podcast.form.complete') ?>
</Forms.Toggler>

</Forms.Section>

<Button variant="primary" type="submit" class="self-end" id="submit-button"><?= lang('Podcast.form.submit_create') ?></Button>

</form>
</div>
<div role="status" id="loading-circle" class="fixed hidden top-1/2 left-1/2">
    <svg aria-hidden="true" class="inline w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-green-500" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
    </svg>
    <span class="sr-only">Loading...</span>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var $uploadImage = document.getElementById('cover');
        var $imagePreview = document.getElementById('imagePreview');
        var croppie = new Croppie($imagePreview, {
            viewport: { width: 200, height: 200, type: 'square' },
            boundary: { width: 300, height: 300 },
        });

        $uploadImage.addEventListener('change', function () {
            $imagePreview.classList.remove('hidden');
            var reader = new FileReader();
            reader.onload = function (e) {
                croppie.bind({ url: e.target.result });
            };
            reader.readAsDataURL(this.files[0]);
        });

        document.getElementById('podcast-form').addEventListener('submit', async function (event) {
            event.preventDefault();
            const title = document.getElementById('title').value;
            const description = document.getElementById('description').value;

            const emptyFields = findEmptyFields([
                { id: 'title', label: 'Title' },
                { id: 'description', label: 'Description' }
            ]);

            if (emptyFields.length > 0) {
                const errorMessage = `Veuillez remplir les champs obligatoires : ${emptyFields.map(field => field.label).join(', ')}.`;
                alert(errorMessage);
                console.log(emptyFields);
                const firstEmptyField = emptyFields[0].id;
                console.log(firstEmptyField);
                const element = document.getElementById(firstEmptyField);
                console.log(element);
                const elementPosition = element.getBoundingClientRect().top + window.scrollY - window.innerHeight / 2;
                console.log(element.getBoundingClientRect().top);
                window.scrollTo({ top: elementPosition, behavior: 'smooth' });
            } else {
                document.getElementById('all').style.opacity = '0.5';
                const submitButton = document.getElementById('submit-button');
                submitButton.disabled = true;
                const loadingCircle = document.getElementById('loading-circle');
                loadingCircle.style.display = 'block';

                var formData = new FormData(this);

                if (document.getElementById('cover').value !== '') {
                    const croppedFile = await getCroppedImageAsFile(croppie);
                    const resizedFile = await resizeImage(croppedFile, 1400);
                    formData.set('cover', resizedFile);
                }

                try {
                    console.log('Form Data:');
                    for (let [key, value] of formData.entries()) {
                        console.log(`${key}:`, value);
                    }
                    const response = await fetch("<?= route_to('podcast-create') ?>", {
                        method: "POST",
                        body: formData,
                    });

                    if (response.ok) {
                        const responseText = await response.text();
                        console.log('Response URL:', response.url);
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(responseText, 'text/html');
                        const alertDiv = doc.querySelector('div[role="alert"]');
                        if (alertDiv && response.url.endsWith('new')) {
                            alert(alertDiv.textContent.trim());
                        } else {
                            window.location.href = "<?= route_to('podcast-list') ?>";
                        }
                    } else {
                        console.error('Erreur de requête:', response.status, response.statusText);
                    }
                } catch (e) {
                    console.error(e);
                }

                loadingCircle.style.display = 'none';
                submitButton.disabled = false;
                document.getElementById('all').style.opacity = '1';
            }
        });

        function findEmptyFields(fields) {
            const emptyFields = [];
            for (const field of fields) {
                const fieldValue = document.getElementById(field.id).value;
                if (!fieldValue) {
                    emptyFields.push(field);
                }
            }
            return emptyFields;
        }

        function scrollPageToTop() {
            const scrollTopElement = document.documentElement || document.body;
            scrollTopElement.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function getCroppedImageAsFile(croppieInstance) {
            return new Promise(resolve => {
                croppieInstance.result({
                    type: 'blob',
                    format: 'jpeg',
                    size: 'original',
                }).then(blob => {
                    const file = new File([blob], 'cropped_image.jpeg', { type: 'image/jpeg' });
                    resolve(file);
                });
            });
        }

        async function resizeImage(file, targetWidth) {
            return new Promise(resolve => {
                const img = new Image();
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    const scaleFactor = targetWidth / img.width;
                    canvas.width = targetWidth;
                    canvas.height = img.height * scaleFactor;
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                    canvas.toBlob(blob => {
                        const resizedFile = new File([blob], file.name, { type: file.type });
                        resolve(resizedFile);
                    }, file.type);
                };
                img.src = URL.createObjectURL(file);
            });
        }
    });
</script>

<?= $this->endSection() ?>
