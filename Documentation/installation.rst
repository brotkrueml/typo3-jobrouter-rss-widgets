.. _installation:

============
Installation
============

Target group: **Administrators**

.. note::

   The extension supports TYPO3 v10 LTS.


.. _installation-requirements:

Requirements
============

The extension has no PHP requirements in addition to TYPO3. You need the
:ref:`TYPO3 Dashboard <dashboard:start>` system extension installed to use this
extension.


.. _installation-composer:

Composer
========

For now only the Composer-based installation is supported:

#. Add a dependency ``brotkrueml/typo3-jobrouter-rss-widgets`` to your project's
   :file:`composer.json` file to install the current version:

   .. code-block:: shell

      composer req brotkrueml/typo3-jobrouter-rss-widgets

#. Activate the extension in the Extension Manager.
