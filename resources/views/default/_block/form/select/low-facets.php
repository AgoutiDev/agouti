<fieldset>
  <label><?= $title; ?></label>
  <input name="low_facet_id" id="low_facet_id">
</fieldset>

<script nonce="<?= $_SERVER['nonce']; ?>">
  var facet_search = async (props = {}) => {
    var settings = {
      method: 'POST',
      mode: 'cors',
      cache: 'no-cache',
      credentials: 'same-origin',
      headers: {
        'Content-Type': 'application/json'
      },
      redirect: 'follow',
      referrerPolicy: 'no-referrer',
      body: JSON.stringify(props)
    };
    try {
      const fetchResponse = await fetch('/search/<?= $type; ?>', settings);
     
      return await fetchResponse.json();
    } catch (e) {
      return e;
    }
  };

  document.addEventListener("DOMContentLoaded", async () => {

    var search_facet = await facet_search();
    var input = document.querySelector('#low_facet_id');
    var options_post = {
      // userInput: false,        // <- отключим пользовательский ввод
      skipInvalid: true, // <- не добавлять повтороно не допускаемые теги
      enforceWhitelist: true, // <- добавлять только из белого списка
      maxTags: 10, // <- ограничим выбор фасетов
      callbacks: {
        "dropdown:show": async (e) => await facet_search(),
      },

      whitelist: search_facet,
    };

    var tagify_post = new Tagify(input, options_post);

    <?php if ($action == 'edit') {   ?>
      tagify_post.addTags(JSON.parse('<?= json_encode($data['low_arr']) ?>'))
    <?php } ?>

  });
</script>