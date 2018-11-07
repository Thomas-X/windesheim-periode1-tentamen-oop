import React from 'react';
import {Helmet} from "react-helmet";

const ForumHome = () => {
	return (
		<div className={'container pageContainer'}>
			<Helmet>
				<link rel={'stylesheet'} href={'css/forumhome.css'}/>
			</Helmet>

			<div className={'header'}>
				<h1>
					Forum home
				</h1>
			</div>

			<a className="btn btn-success" href={JSDATA.routes['forum-post-create']}>
				<i className={'fas fa-plus'}></i> create a new post
			</a>


			<div className={'postsContainer'}>
				<ul className={'list-group'}>
					{JSDATA.posts.map(({name, lastTimeStamp, fname, lname, id}, idx) => {
						return (
							<a key={idx} className={'list-group-item'} href={`${JSDATA.routes['forum-post-read']}?id=${id}`}>
								<h3>{name}</h3>
								<h5 className={'text-muted'}>
									<i>By {fname} {lname} at {lastTimeStamp}</i>
								</h5>
							</a>
						);
					})}
				</ul>
			</div>
		</div>
	);
};

export default ForumHome;