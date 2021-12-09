/**
 * requirejs-config.js
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/simplereturns/LICENSE.txt
 *
 * @package       Tmo_SimpleReturns
 * @copyright     Copyright (C) 2019 Aurora Extensions <support@auroraextensions.com>
 * @license       MIT License
 */
var config = {
    paths: {
        'dropzone': 'Tmo_SimpleReturns/js/plugins/dropzone',
        'jquery.print': 'Tmo_SimpleReturns/js/plugins/jquery.print'
    },
    shim: {
        'jquery.print': {
            'deps': ['jquery']
        }
    },
    map: {
        '*': {
            simpleReturnsLabelPrint: 'Tmo_SimpleReturns/js/print',
            simpleReturnsDragAndDrop: 'Tmo_SimpleReturns/js/dnd'
        }
    }
};
