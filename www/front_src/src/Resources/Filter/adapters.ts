import { propEq, pipe } from 'ramda';

import {
  criteriaValueNameById,
  CriteriaValue,
  RawFilter,
  RawCriteria,
  Filter,
} from './models';

const toFilter = ({ name, criterias }: RawFilter): Filter => {
  const findCriteriaByName = (criteriaName): RawCriteria =>
    criterias.find(propEq('name', criteriaName)) as RawCriteria;

  const toStandardMultiSelectCriteriaValue = (criteria): Array<CriteriaValue> =>
    criteria.value.map(({ id }) => ({
      id,
      name: criteriaValueNameById[id],
    }));

  const getStandardMultiSelectCriteriaValue = (rawName): Array<CriteriaValue> =>
    pipe(findCriteriaByName, toStandardMultiSelectCriteriaValue)(rawName);

  return {
    id: name,
    name,
    criterias: {
      resourceTypes: getStandardMultiSelectCriteriaValue('resource_types'),
      states: getStandardMultiSelectCriteriaValue('states'),
      statuses: getStandardMultiSelectCriteriaValue('statuses'),
      hostGroups: findCriteriaByName('host_groups').value as Array<
        CriteriaValue
      >,
      serviceGroups: findCriteriaByName('service_groups').value as Array<
        CriteriaValue
      >,
      search: findCriteriaByName('search').value as string | undefined,
    },
  };
};

const toRawFilter = ({ name, criterias }: Filter): Omit<RawFilter, 'id'> => {
  return {
    name,
    criterias: [
      {
        name: 'resource_types',
        value: criterias.resourceTypes,
        type: 'multi_select',
      },
      {
        name: 'states',
        value: criterias.states,
        type: 'multi_select',
      },
      {
        name: 'statuses',
        value: criterias.statuses,
        type: 'multi_select',
      },
      {
        name: 'host_groups',
        value: criterias.hostGroups,
        type: 'multi_select',
      },
      {
        name: 'service_groups',
        value: criterias.serviceGroups,
        type: 'multi_select',
        objectType: 'service_groups',
      },
      {
        name: 'host_groups',
        value: criterias.hostGroups,
        type: 'multi_select',
        objectType: 'host_groups',
      },
      {
        name: 'search',
        value: criterias.search,
        type: 'text',
      },
    ],
  };
};

export { toRawFilter, toFilter };
