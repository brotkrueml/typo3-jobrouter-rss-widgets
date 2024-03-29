.. _installation:

============
Installation
============

Target group: **Administrators**

.. attention::
   This TYPO3 extension is no longer maintained.

.. note::
   The extension supports TYPO3 v10 LTS and TYPO3 v11 LTS.


.. _installation-requirements:

Requirements
============

The extension has no PHP requirements in addition to TYPO3. You need the
:ref:`TYPO3 Dashboard <dashboard:start>` system extension installed to use this
extension.


.. _installation-composer:

Installation via composer
=========================

#. Add a dependency ``brotkrueml/typo3-jobrouter-rss-widgets`` to your project's
   :file:`composer.json` file to install the current stable version:

   .. code-block:: shell

      composer req brotkrueml/typo3-jobrouter-rss-widgets

#. Activate the extension in the Extension Manager.


.. _installation-extension-manager:

Installation in Extension Manager
=================================

The extension needs to be installed as any other extension of TYPO3 CMS in
the Extension Manager:

#. Switch to the module :guilabel:`Admin Tools` > :guilabel:`Extensions`.

#. Get the extension

   #. **Get it from the Extension Manager:** Select the
      :guilabel:`Get Extensions` entry in the upper menu bar, search for the
      extension key ``jobrouter_rss_widgets`` and import the extension from the
      repository.

   #. **Get it from typo3.org:** You can always get the current version from
      `https://extensions.typo3.org/extension/jobrouter_rss_widgets/
      <https://extensions.typo3.org/extension/jobrouter_rss_widgets/>`_ by
      downloading either the ``t3x`` or ``zip`` version. Upload the file
      afterwards in the Extension Manager.
