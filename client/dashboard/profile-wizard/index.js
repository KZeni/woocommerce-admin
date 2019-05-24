/** @format */
/**
 * External dependencies
 */
import { __ } from '@wordpress/i18n';
import { Component, createElement } from '@wordpress/element';

/**
 * Internal depdencies
 */
import Plugins from './steps/plugins';
import Start from './steps/start/';
import StoreDetails from './steps/store-details';
import './style.scss';

const getSteps = () => {
	const steps = [];

	steps.push( {
		key: 'start',
		container: Start,
	} );
	steps.push( {
		key: 'plugins',
		container: Plugins,
	} );
	steps.push( {
		key: 'store-details',
		container: StoreDetails,
		label: __( 'Store Details', 'woocommerce-admin' ),
	} );

	return steps;
};

export default class ProfileWizard extends Component {
	componentDidMount() {
		document.documentElement.classList.remove( 'wp-toolbar' );
		document.body.classList.add( 'woocommerce-profile-wizard__body' );
	}

	componentWillUnmount() {
		document.documentElement.classList.add( 'wp-toolbar' );
		document.body.classList.remove( 'woocommerce-profile-wizard__body' );
	}

	getStep() {
		const { step } = this.props.query;
		const currentStep = getSteps().find( s => s.key === step );

		if ( ! currentStep ) {
			return getSteps()[ 0 ];
		}

		return currentStep;
	}

	render() {
		const { query } = this.props;
		const step = this.getStep();

		return createElement( step.container, { query } );
	}
}
