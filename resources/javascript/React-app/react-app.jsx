import React from "react";
import ReactDOM from "react-dom";
import ForumHome from "./ForumHome";

/*
* Determines which component to use, uses a HOC for passing props down to used components
* */
const App = () => {
	let Route = (props) => null;
	switch (JSDATA.component) {
		case 'forum-home':
			Route = (props) => <ForumHome {...props}/>;
			break;
		// check your components here, defined in App.php
	}

	return (
			<div className={'minimumHeight'}>
				<Route/>
			</div>
	);
};

ReactDOM.render(<App/>, document.getElementById("react-container"));