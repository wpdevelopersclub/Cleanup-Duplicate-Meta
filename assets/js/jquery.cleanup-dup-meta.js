/*!
 * JavaScript|jQuery functions
 *
 * Load into cleanupDupMeta namespace
 *
 * @package     Cleanup_Dup_Meta
 * @since       1.0.1
 * @author      WP Developers Club and Tonya
 * @link        http://wpdevelopersclub.com/wordpress-plugins/cleanup-duplicate-meta/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

;(function( $, window, document, undefined ){

    'use_strict';

    var cleanupDupMeta = cleanupDupMeta || {};

    cleanupDupMeta.init = function() {

        cleanupDupMeta.containers = {
            postmeta : $('.cleanup-dup-postmeta-container'),
            usermeta : $('.cleanup-dup-usermeta-container')
        }
        cleanupDupMeta.buttons = {
            postmeta : {
                cleanup   : $('#cleanup-dup-postmeta'),
                count     : $('#cleanup-dup-postmeta-count'),
                query     : $('#cleanup-dup-postmeta-query')
            },
            usermeta : {
                cleanup   : $('#cleanup-dup-usermeta'),
                count     : $('#cleanup-dup-usermeta-count'),
                query     : $('#cleanup-dup-usermeta-query')
            }
        }
        cleanupDupMeta.loadingImgs = {
            postmeta : cleanupDupMeta.containers.postmeta.find( '.status img' ),
            usermeta : cleanupDupMeta.containers.usermeta.find( '.status img' )
        }

        _bindButtons();
    }

    /********************
     * Button Binding
     *******************/

    /**
     * Bind each of the buttons to the function _triggerAjax.  When a button is clicked,
     * _triggerAJax is fired.
     *
     * @since 1.0.0
     *
     * @private
     */
    function _bindButtons() {
        $.each( cleanupDupMeta.buttons, function( type, buttons ){
            $.each( buttons, function( buttonType, $button ){

                //* Store the data onto the element
                $button.data( '_cleanup_dups_meta', {
                    type        : type,
                    buttonType  : buttonType,
                    data        : _buildData( type, $button.data( 'action' ) ),
                    isUserMeta  : 'usermeta' === type ? true : false
                });

                // Now bind
                _bindOnClick( $button, this );
            });
        });
    }

    /**
     * Bind the button's click event to the proxy callback
     *
     * @since 1.0.0
     *
     * @param $button
     * @param context
     * @private
     */
    function _bindOnClick( $button, context ) {
        //* Bind the callback to the click event
        $button.bind( 'click.cleanupDupMeta', $.proxy( _triggerAjax, context ) );
    }

    /**
     * Unbind the button's click event from the proxy callback
     *
     * @since 1.0.0
     *
     * @param $button
     * @private
     */
    function _unbindOnClick( $button ) {
        $button.unbind( 'click.cleanupDupMeta', _triggerAjax );
    }

    /**
     * Trigger AJAX Callback - fired when a button is clicked
     *
     * @since 1.0.0
     *
     * @param event
     * @returns {boolean}
     * @private
     */
    function _triggerAjax( event ) {

        var _data           = $(this).data( '_cleanup_dups_meta');

        _data.isUserMeta    = true === _data.isUserMeta ? true : false;

        // Check first/last radio buttons
        _data.data.keep_first = cleanupDupMeta.containers[ _data.type ].find( 'input[name=cleanup-dup-meta-keep]:checked' ).val();

        _ajaxHandler( $(this), _data );

        return false;
    }

    /********************
     * AJAX
     *******************/

    /**
     * AJAX Handler
     *
     * @since 1.0.0
     *
     * @param $button
     * @param data
     * @param boolean   isUserMeta  Default false
     * @returns {boolean}
     * @private
     */
    function _ajaxHandler( $button, _data ) {

        var $message = cleanupDupMeta.containers[ _data.type ].find( '.message-' + _data.buttonType);

        $.ajax({
            type: 'POST',
            url: cleanupDupMeta.params.ajaxurl,
            data: _data.data,
            beforeSend: function( xhr ) {
                _buttonsHandler( true );

                _loadingImageHandler( true, _data.isUserMeta );
            }
        })
        .done(function( response ) {
            if ( 'query' == _data.buttonType ) {
                //console.log( response );
                $message.html( response );
            } else {
                $message.find('span').text(response);
                $message.show();
            }
        })
        .fail(function( XMLHttpRequest, textStatus, errorThrown ) {
            $message.hide();
            console.log('something went wrong');
        })
        .always(function() {
            _loadingImageHandler( false, _data.isUserMeta );

            _buttonsHandler( false );
        });

        return false;
    }

    /********************
     * Private Helpers
     *******************/

    /**
     * Build the data packet for AJAX
     *
     * @since 1.0.0
     *
     * @param string        type
     * @param string        action
     * @returns {{security: *, action: string, keep_first: *}}
     * @private
     */
    function _buildData( type, action ) {
        var $container = cleanupDupMeta.containers[ type ];

        return {
            security    : $container.find( '#_wpnonce' ).val(),
            action      : action,
            keep_first  : $container.find( 'input[name=cleanup-dup-meta-keep]:checked' ).val()
        };
    }

    /**
     * Lock the buttons during AJAX
     *
     * @since 1.0.0
     *
     * @param boolean         lockButtons
     * @returns {boolean}
     * @private
     */
    function _buttonsHandler( lockButtons ) {

        $.each( cleanupDupMeta.buttons, function( type, buttons ){
            $.each( buttons, function( buttonIndex, $button ) {
                if ( lockButtons ) {
                    _lockButtons( $button );
                } else {
                    _resetButtons( $button, this );
                }
            });
        });

        return false;
    }

    /**
     * Lock the buttons during AJAX
     *
     * @since 1.0.0
     *
     * @param $button
     * @returns {boolean}
     * @private
     */
    function _lockButtons( $button ) {

        _unbindOnClick( $button );

        $button
            .prop('readonly', true)
            .css('background-color', '#ccc');

        $button = null;

        return false;
    }

    /**
     * Unlock the buttons (resets back to normal state)
     *
     * This occurs after AJAX is complete.
     *
     * @since 1.0.0
     *
     * @param $button
     * @param string        context
     * @returns {boolean}
     * @private
     */
    function _resetButtons( $button, context ) {

        _bindOnClick( $button, context )

        $button
            .prop( 'readonly', false )
            .removeAttr( 'style' );

        // Release memory
        $button = null;

        return false;
    }

    function _loadingImageHandler( showImage, isUserMeta ) {
        var index = isUserMeta ? 'usermeta' : 'postmeta';

        cleanupDupMeta.loadingImgs[ index ].toggle( showImage );

        return false
    }

    $(document).ready(function () {

        if ( typeof cleanup_dup_meta_params === 'undefined' ) {
            console.log( 'Whoops, local params not passed from WordPress.' );
        } else {
            cleanupDupMeta.params = cleanup_dup_meta_params;

            cleanupDupMeta.init();
        }
    });

})(jQuery, window, document);