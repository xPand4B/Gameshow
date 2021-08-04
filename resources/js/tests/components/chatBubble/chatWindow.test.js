import TestBehaviour from '../../TestBehaviour';
import Component from '../../../src/components/chatBubble/chatWindow';

describe('chatBubble.chatWindow', () => {
    beforeEach(() => {
        TestBehaviour.beforeEach();
    })

    test('component can be mounted', () => {
        const wrapper = TestBehaviour.mountFunction(Component);

        expect(wrapper.html()).toMatchSnapshot();
    });

});
