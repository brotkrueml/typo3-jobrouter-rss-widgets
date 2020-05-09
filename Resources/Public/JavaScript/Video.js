require([
  'TYPO3/CMS/Core/Event/RegularEvent',
  'TYPO3/CMS/Backend/Modal'
], function(RegularEvent, Modal) {
  const selector = '.jobrouter-rss-widgets-video-link';

  new RegularEvent('click', function (e) {
    e.preventDefault();

    const linkElement = e.target.closest(selector)
    const configuration = {
      type: Modal.types.iframe,
      title: linkElement.dataset.title,
      content: linkElement.href,
      size: Modal.sizes.medium,
    };

    Modal.advanced(configuration);
  }).delegateTo(document, selector);
})
