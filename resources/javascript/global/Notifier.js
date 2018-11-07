import $ from 'jquery';

export default class Notifier {

    constructor() {
        // I tried to use a babel-loader plugin but after fiugring it out for 1 hour I gave up so no field types for us :)
        this.success = 'success';
        this.error = 'danger';
        this.warning = 'warning';
        this.info = 'info';

        this.currentNotifications = 0;
        this.heights = [];
        this.notificationTime = 3000;
        this.notificationPopUpTime = 200;
        this.notificationDissepearTime = 2500;
        this.margin = 16;
    }

    async determineNotifications(notifications) {
        for (const notification of notifications) {
            const payload = notification.message;
            switch (notification.type) {
                case this.success:
                    this.notifySuccess(payload)
                    break;
                case this.error:
                    this.notifyError(payload)
                    break;
                case this.warning:
                    this.notifyWarning(payload)
                    break;
                case this.info:
                    this.notifyInfo(payload)
                    break;
            }
            await new Promise((resolve) => setTimeout(() => {
                resolve()
            }, this.notificationPopUpTime))
        }
        setTimeout(() => {
            this.reset();
        }, this.notificationTime)
    }

    notifySuccess(val) {
        return this.init(this.success, val)
    }

    notifyError(val) {
        return this.init(this.error, val)
    }

    notifyWarning(val) {
        return this.init(this.warning, val)
    }

    notifyInfo(val) {
        return this.init(this.info, val)
    }

    init(type, val) {
        const className = `alert alert-${type} `;
        const _id = `alert-${this.currentNotifications}`;
        const id = `#${_id}`;
        const html = `<div class="${className}" id="${_id}" style="top: -60vh;">${val}</div>`;
        $("body").append(html);

        const domEl = $(id)
            .get(0)
        const dimensions = domEl
            .getBoundingClientRect();

        let totalHeight = 0;
        this.heights.map((val, idx) => totalHeight += val)

        const offset = this.currentNotifications > 0
            ? `${totalHeight + (this.margin * (this.currentNotifications + 1))}px`
            : '16px'

        domEl.style.top = offset;
        this.heights.push(dimensions.height);
        this.currentNotifications += 1;
    }

    async reset() {
        for (let i = (this.currentNotifications - 1); i > -1; i--) {
            const curId = `#alert-${i}`;
            $(curId).get(0).style.top = '-60vh';
            await new Promise((resolve) => setTimeout(() => {
                $(curId).remove()
                resolve()
            }, this.notificationDissepearTime))
        }
    }
}