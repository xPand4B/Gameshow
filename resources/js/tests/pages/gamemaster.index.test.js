import TestBehaviour from '../TestBehaviour';
import Component from '../../src/pages/gamemaster/index';

describe('Gamemaster.Index', () => {
    beforeEach(() => TestBehaviour.beforeEach())

    test('component can be mounted', () => {
        const wrapper = TestBehaviour.mountFunction(Component);

        expect(wrapper.html()).toMatchSnapshot();
    });

});
