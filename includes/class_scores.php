<?php

    class scores {

        // All answered questions
        private function all_responses($user_id){
            global $db;
            $results = array();

            $query = "SELECT * FROM q_answers WHERE user_id = '$user_id'";
            $result = $db->query($query);
            while($obj = $result->fetch_object()){
                $results[] = $obj;
            }
            return $results;
        }

        public function check_question_type($question_id){
            global $db;
            $results = array();
            $query = "SELECT sub_category FROM questions WHERE question_id = '$question_id'";
            $result = $db->query($query);
            while($obj = $result->fetch_object()){
                $results[] = $obj;
            }
            return $results[0];
        }

        private function check_total_questions($sub_category){
            global $db;
            $results = array();
            $query = "SELECT * FROM questions WHERE sub_category = '$sub_category'";
            $result = $db->query($query);
            while($obj = $result->fetch_object()){
                $results[] = $obj;
            }
            return $results;
        }

        private function check_biz_phase($user_id){
            global $db;
            $results = array();
            $query = "SELECT stage FROM businesses WHERE user_id = '$user_id'";
            $result = $db->query($query);
            while($obj = $result->fetch_object()){
                $results[] = $obj;
            }
            return $results[0];
        }

        private function concept_scores($user_id){
            $all_responses = $this->all_responses($user_id);
            $question_type = array();
            $biz_phase = $this->check_biz_phase($user_id);
            $all_scores = array();

            // counter variables
            $value_proposition_index = 0;
            $customer_segments_index = 0;
            $channels_index = 0;
            $customer_relationships_index = 0;
            $revenue_streams_index = 0;
            $key_activities_index = 0;
            $key_resources_index = 0;
            $key_partners_index = 0;
            $cost_structures_index = 0;
            $current_alternatives_index = 0;
            $proof_of_concept_index = 0;
            $unique_selling_point_index = 0;

            foreach($all_responses as $v){
                if($v->yes_answer == 1){
                    $question_id = $v->question_id;
                    $question_type[] = $this->check_question_type($question_id);

                }
            }
            foreach($question_type as $v){
                // business concept
                if ($v->sub_category == 'value proposition'){ $value_proposition_index += 1; }
                if ($v->sub_category == 'customer segments'){ $customer_segments_index += 1; }
                if ($v->sub_category == 'channels'){ $channels_index += 1; }
                if ($v->sub_category == 'customer relationships'){ $customer_relationships_index += 1; }
                if ($v->sub_category == 'revenue streams'){ $revenue_streams_index += 1; }
                if ($v->sub_category == 'key activities'){ $key_activities_index += 1; }
                if ($v->sub_category == 'key resources'){ $key_resources_index += 1; }
                if ($v->sub_category == 'key partners'){ $key_partners_index += 1; }
                if ($v->sub_category == 'cost structure'){ $cost_structures_index += 1; }
                if ($v->sub_category == 'current alternatives'){ $current_alternatives_index += 1; }
                if ($v->sub_category == 'proof of concept'){ $proof_of_concept_index += 1; }
                if ($v->sub_category == 'unique selling point'){ $unique_selling_point_index += 1; }

            }
            // post revenue scores
            if ($biz_phase->stage === 'pre-revenue' || $biz_phase->stage === 'idea'){
                // value proposition scores
                $value_proposition_score = $value_proposition_index * 3;
                $value_proposition_total = count($this->check_total_questions('value proposition'));
                $value_proposition_av = $value_proposition_index / $value_proposition_total * 100;
                $all_scores[] = array('type' => 'value proposition',
                                    'score' => $value_proposition_score,
                                    'total' => $value_proposition_total,
                                    'average' => $value_proposition_av);

                // customer segments scores
                $customer_segments_score = $customer_segments_index * 3;
                $customer_segments_total = count($this->check_total_questions('customer segments'));
                $customer_segments_av = $customer_segments_index / $customer_segments_total * 100;
                $all_scores[] = array('type' => 'customer segments',
                                    'score' => $customer_segments_score,
                                    'total' => $customer_segments_total,
                                    'average' => $customer_segments_av);

                // channels scores
                $channels_score = $channels_index * 2;
                $channels_total = count($this->check_total_questions('channels'));
                $channels_av = $channels_index / $channels_total * 100;
                $all_scores[] = array('type' => 'channels',
                                    'score' => $channels_score,
                                    'total' => $channels_total,
                                    'average' => $channels_av);

                 // customer relationships scores
                $customer_relationships_score = $customer_relationships_index * 1;
                $customer_relationships_total = count($this->check_total_questions('customer relationships'));
                $customer_relationships_av = $customer_relationships_index / $customer_relationships_total * 100;
                $all_scores[] = array('type' => 'customer relationships',
                                    'score' => $customer_relationships_score,
                                    'total' => $customer_relationships_total,
                                    'average' => $customer_relationships_av);

                // revenue streams scores
                $revenue_streams_score = $revenue_streams_index * 1;
                $revenue_streams_total = count($this->check_total_questions('revenue streams'));
                $revenue_streams_av = $revenue_streams_index / $revenue_streams_total * 100;
                $all_scores[] = array('type' => 'revenue streams',
                                    'score' => $revenue_streams_score,
                                    'total' => $revenue_streams_total,
                                    'average' => $revenue_streams_av);

                // key activities score
                $key_activities_score = $key_activities_index * 2;
                $key_activities_total = count($this->check_total_questions('key activities'));
                $key_activities_av = $key_activities_index / $key_activities_total * 100;
                $all_scores[] = array('type' => 'key activities',
                                    'score' => $key_activities_score,
                                    'total' => $key_activities_total,
                                    'average' => $key_activities_av);

                // key resources scores
                $key_resources_score = $key_resources_index * 1;
                $key_resources_total = count($this->check_total_questions('key resources'));
                $key_resources_av = $key_resources_index / $key_resources_total * 100;
                $all_scores[] = array('type' => 'key resources',
                                    'score' => $key_resources_score,
                                    'total' => $key_resources_total,
                                    'average' => $key_resources_av);

                // key partners scores
                $key_partners_score = $key_partners_index * 1;
                $key_partners_total = count($this->check_total_questions('key partners'));
                $key_partners_av = $key_partners_index / $key_partners_total * 100;
                $all_scores[] = array('type' => 'key partners',
                                    'score' => $key_partners_score,
                                    'total' => $key_partners_total,
                                    'average' => $key_partners_av);

                // cost structure scores
                $cost_structures_score = $cost_structures_index * 1;
                $cost_structures_total = count($this->check_total_questions('cost structure'));
                $cost_structures_av = $cost_structures_index / $cost_structures_total * 100;
                $all_scores[] = array('type' => 'cost structure',
                                    'score' => $cost_structures_score,
                                    'total' => $cost_structures_total,
                                    'average' => $cost_structures_av);

                // current alternatives score
                $current_alternatives_score = $current_alternatives_index * 1;
                $current_alternatives_total = count($this->check_total_questions('current alternatives'));
                $current_alternatives_av = $current_alternatives_index / $current_alternatives_total * 100;
                $all_scores[] = array('type' => 'current alternatives',
                                    'score' => $current_alternatives_score,
                                    'total' => $current_alternatives_total,
                                    'average' => $current_alternatives_av);

                // proof of concept scores
                $proof_of_concept_score = $proof_of_concept_index * 1;
                $proof_of_concept_total = count($this->check_total_questions('proof of concept'));
                $proof_of_concept_av = $proof_of_concept_index / $proof_of_concept_total * 100;
                $all_scores[] = array('type' => 'proof of concept',
                                    'score' => $proof_of_concept_score,
                                    'total' => $current_alternatives_total,
                                    'average' => $proof_of_concept_av);

                // unique selling point scores
                $unique_selling_point_score =  $unique_selling_point_index * 1;
                $unique_selling_point_total = count($this->check_total_questions('unique selling point'));
                $unique_selling_point_av = $unique_selling_point_index / $unique_selling_point_total * 100;
                $all_scores[] = array('type' => 'unique selling point',
                                    'score' => $unique_selling_point_score,
                                    'total' => $unique_selling_point_total,
                                    'average' => $unique_selling_point_av);
            }

            elseif ($biz_phase->stage == 'post-revenue' || $biz_phase->stage === 'established') {
                // value proposition scores
                $value_proposition_score = $value_proposition_index * 3;
                $value_proposition_total = count($this->check_total_questions('value proposition'));
                $value_proposition_av = $value_proposition_index / $value_proposition_total * 100;
                $all_scores[] = array('type' => 'value proposition',
                    'score' => $value_proposition_score,
                    'total' => $value_proposition_total,
                    'average' => $value_proposition_av);

                // customer segments scores
                $customer_segments_score = $customer_segments_index * 3;
                $customer_segments_total = count($this->check_total_questions('customer segments'));
                $customer_segments_av = $customer_segments_index / $customer_segments_total * 100;
                $all_scores[] = array('type' => 'customer segments',
                    'score' => $customer_segments_score,
                    'total' => $customer_segments_total,
                    'average' => $customer_segments_av);

                // channels scores
                $channels_score = $channels_index * 2;
                $channels_total = count($this->check_total_questions('channels'));
                $channels_av = $channels_index / $channels_total * 100;
                $all_scores[] = array('type' => 'channels',
                    'score' => $channels_score,
                    'total' => $channels_total,
                    'average' => $channels_av);

                // customer relationships scores
                $customer_relationships_score = $customer_relationships_index * 1;
                $customer_relationships_total = count($this->check_total_questions('customer relationships'));
                $customer_relationships_av = $customer_relationships_index / $customer_relationships_total * 100;
                $all_scores[] = array('type' => 'customer relationships',
                    'score' => $customer_relationships_score,
                    'total' => $customer_relationships_total,
                    'average' => $customer_relationships_av);

                // revenue streams scores
                $revenue_streams_score = $revenue_streams_index * 1;
                $revenue_streams_total = count($this->check_total_questions('revenue streams'));
                $revenue_streams_av = $revenue_streams_index / $revenue_streams_total * 100;
                $all_scores[] = array('type' => 'revenue streams',
                    'score' => $revenue_streams_score,
                    'total' => $revenue_streams_total,
                    'average' => $revenue_streams_av);

                // key activities score
                $key_activities_score = $key_activities_index * 2;
                $key_activities_total = count($this->check_total_questions('key activities'));
                $key_activities_av = $key_activities_index / $key_activities_total * 100;
                $all_scores[] = array('type' => 'key activities',
                    'score' => $key_activities_score,
                    'total' => $key_activities_total,
                    'average' => $key_activities_av);

                // key resources scores
                $key_resources_score = $key_resources_index * 1;
                $key_resources_total = count($this->check_total_questions('key resources'));
                $key_resources_av = $key_resources_index / $key_resources_total * 100;
                $all_scores[] = array('type' => 'key resources',
                    'score' => $key_resources_score,
                    'total' => $key_resources_total,
                    'average' => $key_resources_av);

                // key partners scores
                $key_partners_score = $key_partners_index * 1;
                $key_partners_total = count($this->check_total_questions('key partners'));
                $key_partners_av = $key_partners_index / $key_partners_total * 100;
                $all_scores[] = array('type' => 'key partners',
                    'score' => $key_partners_score,
                    'total' => $key_partners_total,
                    'average' => $key_partners_av);

                // cost structure scores
                $cost_structures_score = $cost_structures_index * 1;
                $cost_structures_total = count($this->check_total_questions('cost structure'));
                $cost_structures_av = $cost_structures_index / $cost_structures_total * 100;
                $all_scores[] = array('type' => 'cost structure',
                    'score' => $cost_structures_score,
                    'total' => $cost_structures_total,
                    'average' => $cost_structures_av);

                // current alternatives score
                $current_alternatives_score = $current_alternatives_index * 1;
                $current_alternatives_total = count($this->check_total_questions('current alternatives'));
                $current_alternatives_av = $current_alternatives_index / $current_alternatives_total * 100;
                $all_scores[] = array('type' => 'current alternatives',
                    'score' => $current_alternatives_score,
                    'total' => $current_alternatives_total,
                    'average' => $current_alternatives_av);

                // proof of concept scores
                $proof_of_concept_score = $proof_of_concept_index * 1;
                $proof_of_concept_total = count($this->check_total_questions('proof of concept'));
                $proof_of_concept_av = $proof_of_concept_index / $proof_of_concept_total * 100;
                $all_scores[] = array('type' => 'proof of concept',
                    'score' => $proof_of_concept_score,
                    'total' => $proof_of_concept_total ,
                    'average' => $proof_of_concept_av);

                // unique selling point scores
                $unique_selling_point_score = $unique_selling_point_index * 1;
                $unique_selling_point_total = count($this->check_total_questions('unique selling point'));
                $unique_selling_point_av = $unique_selling_point_index / $unique_selling_point_total * 100;
                $all_scores[] = array('type' => 'unique selling point',
                    'score' => $unique_selling_point_score,
                    'total' => $unique_selling_point_total,
                    'average' => $unique_selling_point_av);
            }
            return $all_scores;
        }

        private function structure_scores($user_id){
            $all_responses = $this->all_responses($user_id);
            $question_type = array();
            $biz_phase = $this->check_biz_phase($user_id);
            $all_scores = array();

            // counter variables
            $business_process_management_index = 0;
            $marketing_index = 0;
            $employee_index = 0;
            $ownership_and_mindset_index = 0;
            $functional_index = 0;
            $business_and_customers_index = 0;
            $growth_index = 0;
            $delivery_and_expertise_index = 0;
            $compliance_index = 0;
            $market_index = 0;
            $financial_management_index = 0;
            $legal_index = 0;
            $commercial_index = 0;
            $labor_index = 0;
            $regulatory_index = 0;
            $e_commerce_index = 0;

            foreach($all_responses as $v){
                if($v->yes_answer == 1){
                    $question_id = $v->question_id;
                    $question_type[] = $this->check_question_type($question_id);

                }
            }
            foreach($question_type as $v){

                // business structure
                if ($v->sub_category == 'business process management'){ $business_process_management_index += 1; }
                if ($v->sub_category == 'marketing and sales'){ $marketing_index += 1; }
                if ($v->sub_category == 'ownership and mindset'){ $ownership_and_mindset_index += 1; }
                if ($v->sub_category == 'employee satisfaction'){ $employee_index += 1; }
                if ($v->sub_category == 'functional capability'){ $functional_index += 1; }
                if ($v->sub_category == 'business and customers'){ $business_and_customers_index += 1; }
                if ($v->sub_category == 'growth strategy'){ $growth_index += 1; }
                if ($v->sub_category == 'delivery and expertise'){ $delivery_and_expertise_index += 1; }
                if ($v->sub_category == 'compliance and certification'){ $compliance_index += 1; }
                if ($v->sub_category == 'market intelligence'){ $market_index += 1; }
                if ($v->sub_category == 'financial management'){ $financial_management_index += 1; }
                if ($v->sub_category == 'legal'){ $legal_index += 1; }
                if ($v->sub_category == 'commercial contracts agreements'){ $commercial_index += 1; }
                if ($v->sub_category == 'e-commerce'){ $e_commerce_index += 1; }
            }
            // post revenue scores
            if ($biz_phase->stage === 'pre-revenue' || $biz_phase->stage === 'idea'){

                // business process management scores
                $business_process_management_score =  $business_process_management_index * 3;
                $business_process_management_total = count($this->check_total_questions('business process management'));
                $business_process_management_av = $business_process_management_index / $business_process_management_total * 100;
                $all_scores[] = array('type' => 'business process management',
                    'score' => $business_process_management_score,
                    'total' => $business_process_management_total,
                    'average' => $business_process_management_av);

                // marketing and sales scores
                $marketing_and_sales_score =  $marketing_index * 3;
                $marketing_and_sales_total = count($this->check_total_questions('marketing and sales'));
                $marketing_and_sales_av = $marketing_index / $marketing_and_sales_total * 100;
                $all_scores[] = array('type' => 'marketing and sales',
                    'score' => $marketing_and_sales_score,
                    'total' => $marketing_and_sales_total,
                    'average' => $marketing_and_sales_av);

                // ownership and mindset scores
                $ownership_and_mindset_score =  $ownership_and_mindset_index * 3;
                $ownership_and_mindset_total = count($this->check_total_questions('ownership and mindset'));
                $ownership_and_mindset_av = $ownership_and_mindset_index / $ownership_and_mindset_total * 100;
                $all_scores[] = array('type' => 'ownership and mindset',
                    'score' => $ownership_and_mindset_score,
                    'total' => $ownership_and_mindset_total,
                    'average' => $ownership_and_mindset_av);

                // employee satisfaction scores
                $employee_satisfaction_score =  $employee_index * 3;
                $employee_satisfaction_total = count($this->check_total_questions('employee satisfaction'));
                $employee_satisfaction_av = $employee_index / $employee_satisfaction_total * 100;
                $all_scores[] = array('type' => 'employee satisfaction',
                    'score' => $employee_satisfaction_score,
                    'total' => $employee_satisfaction_total,
                    'average' => $employee_satisfaction_av);

                // functional capability scores
                $functional_capability_score =  $functional_index * 3;
                $functional_capability_total = count($this->check_total_questions('functional capability'));
                $functional_capability_av = $functional_index / $functional_capability_total * 100;
                $all_scores[] = array('type' => 'functional capability',
                    'score' => $functional_capability_score,
                    'total' => $functional_capability_total,
                    'average' => $functional_capability_av);

                // business and customers scores
                $business_and_customers_score =  $business_and_customers_index * 2;
                $business_and_customers_total = count($this->check_total_questions('business and customers'));
                $business_and_customers_av = $business_and_customers_index / $business_and_customers_total * 100;
                $all_scores[] = array('type' => 'business and customers',
                    'score' => $business_and_customers_score,
                    'total' => $business_and_customers_total,
                    'average' => $business_and_customers_av);

                // delivery and expertise scores
                $delivery_and_expertise_score =  $delivery_and_expertise_index * 1;
                $delivery_and_expertise_total = count($this->check_total_questions('delivery and expertise'));
                $delivery_and_expertise_av = $delivery_and_expertise_index / $delivery_and_expertise_total * 100;
                $all_scores[] = array('type' => 'delivery and expertise',
                    'score' => $delivery_and_expertise_score,
                    'total' => $delivery_and_expertise_total,
                    'average' => $delivery_and_expertise_av);

                // compliance and certification scores
                $compliance_and_certification_score =  $compliance_index * 1;
                $compliance_and_certification_total = count($this->check_total_questions('compliance and certification'));
                $compliance_and_certification_av = $compliance_index / $compliance_and_certification_total * 100;
                $all_scores[] = array('type' => 'compliance and certification',
                    'score' => $compliance_and_certification_score,
                    'total' => $compliance_and_certification_total,
                    'average' => $compliance_and_certification_av);

                // market intelligence scores
                $market_intelligence_score =  $market_index * 1;
                $market_intelligence_total = count($this->check_total_questions('market intelligence'));
                $market_intelligence_av = $market_index / $market_intelligence_total * 100;
                $all_scores[] = array('type' => 'market intelligence',
                    'score' => $market_intelligence_score,
                    'total' => $market_intelligence_total,
                    'average' => $market_intelligence_av);

                // growth strategy scores
                $growth_strategy_score =  $growth_index * 1;
                $growth_strategy_total = count($this->check_total_questions('growth strategy'));
                $growth_strategy_av = $growth_index / $growth_strategy_total * 100;
                $all_scores[] = array('type' => 'growth strategy',
                    'score' => $growth_strategy_score,
                    'total' => $growth_strategy_total,
                    'average' => $growth_strategy_av);

                // financial management scores
                $financial_management_score =  $financial_management_index * 2;
                $financial_management_total = count($this->check_total_questions('financial management'));
                $financial_management_av = $financial_management_index / $financial_management_total * 100;
                $all_scores[] = array('type' => 'financial management',
                    'score' => $financial_management_score,
                    'total' => $financial_management_total,
                    'average' => $financial_management_av);

                // legal scores
                $legal_score =  $legal_index * 1;
                $legal_total = count($this->check_total_questions('legal'));
                $legal_av = $legal_index / $legal_total * 100;
                $all_scores[] = array('type' => 'legal',
                    'score' => $legal_score,
                    'total' => $legal_total,
                    'average' => $legal_av);

                // commercial contracts agreements scores
                $commercial_score =  $commercial_index * 1;
                $commercial_total = count($this->check_total_questions('commercial contracts agreements'));
                $commercial_av = $commercial_index / $commercial_total * 100;
                $all_scores[] = array('type' => 'commercial contracts agreements',
                    'score' => $commercial_score,
                    'total' => $commercial_total,
                    'average' => $commercial_av);

                // e-commerce scores
                $e_commerce_score =  $e_commerce_index * 1;
                $e_commerce_total = count($this->check_total_questions('e-commerce'));
                $e_commerce_av = $e_commerce_index / $e_commerce_total * 100;
                $all_scores[] = array('type' => 'e-commerce',
                    'score' => $e_commerce_score,
                    'total' => $e_commerce_total,
                    'average' => $e_commerce_av);

                return $all_scores;
            }

            elseif ($biz_phase->stage == 'post-revenue' || $biz_phase->stage === 'established') {
                // business process management scores
                $business_process_management_score = $business_process_management_index * 3;
                $business_process_management_total = count($this->check_total_questions('business process management'));
                $business_process_management_av = $business_process_management_index / $business_process_management_total * 100;
                $all_scores[] = array('type' => 'business process management',
                    'score' => $business_process_management_score,
                    'total' => $business_process_management_total,
                    'average' => $business_process_management_av);

                // marketing and sales scores
                $marketing_and_sales_score = $marketing_index * 3;
                $marketing_and_sales_total = count($this->check_total_questions('marketing and sales'));
                $marketing_and_sales_av = $marketing_index / $marketing_and_sales_total * 100;
                $all_scores[] = array('type' => 'marketing and sales',
                    'score' => $marketing_and_sales_score,
                    'total' => $marketing_and_sales_total,
                    'average' => $marketing_and_sales_av);

                // ownership and mindset scores
                $ownership_and_mindset_score = $ownership_and_mindset_index * 3;
                $ownership_and_mindset_total = count($this->check_total_questions('ownership and mindset'));
                $ownership_and_mindset_av = $ownership_and_mindset_index / $ownership_and_mindset_total * 100;
                $all_scores[] = array('type' => 'ownership and mindset',
                    'score' => $ownership_and_mindset_score,
                    'total' => $ownership_and_mindset_total,
                    'average' => $ownership_and_mindset_av);

                // employee satisfaction scores
                $employee_satisfaction_score = $employee_index * 3;
                $employee_satisfaction_total = count($this->check_total_questions('employee satisfaction'));
                $employee_satisfaction_av = $employee_index / $employee_satisfaction_total * 100;
                $all_scores[] = array('type' => 'employee satisfaction',
                    'score' => $employee_satisfaction_score,
                    'total' => $employee_satisfaction_total,
                    'average' => $employee_satisfaction_av);

                // functional capability scores
                $functional_capability_score = $functional_index * 3;
                $functional_capability_total = count($this->check_total_questions('functional capability'));
                $functional_capability_av = $functional_index / $functional_capability_total * 100;
                $all_scores[] = array('type' => 'functional capability',
                    'score' => $functional_capability_score,
                    'total' => $functional_capability_total,
                    'average' => $functional_capability_av);

                // business and customers scores
                $business_and_customers_score = $business_and_customers_index * 2;
                $business_and_customers_total = count($this->check_total_questions('business and customers'));
                $business_and_customers_av = $business_and_customers_index / $business_and_customers_total * 100;
                $all_scores[] = array('type' => 'business and customers',
                    'score' => $business_and_customers_score,
                    'total' => $business_and_customers_total,
                    'average' => $business_and_customers_av);

                // delivery and expertise scores
                $delivery_and_expertise_score = $delivery_and_expertise_index * 1;
                $delivery_and_expertise_total = count($this->check_total_questions('delivery and expertise'));
                $delivery_and_expertise_av = $delivery_and_expertise_index / $delivery_and_expertise_total * 100;
                $all_scores[] = array('type' => 'delivery and expertise',
                    'score' => $delivery_and_expertise_score,
                    'total' => $delivery_and_expertise_total,
                    'average' => $delivery_and_expertise_av);

                // compliance and certification scores
                $compliance_and_certification_score = $compliance_index * 1;
                $compliance_and_certification_total = count($this->check_total_questions('compliance and certification'));
                $compliance_and_certification_av = $compliance_index / $compliance_and_certification_total * 100;
                $all_scores[] = array('type' => 'compliance and certification',
                    'score' => $compliance_and_certification_score,
                    'total' => $compliance_and_certification_total,
                    'average' => $compliance_and_certification_av);

                // market intelligence scores
                $market_intelligence_score = $market_index * 1;
                $market_intelligence_total = count($this->check_total_questions('market intelligence'));
                $market_intelligence_av = $market_index / $market_intelligence_total * 100;
                $all_scores[] = array('type' => 'market intelligence',
                    'score' => $market_intelligence_score,
                    'total' => $market_intelligence_total,
                    'average' => $market_intelligence_av);

                // growth strategy scores
                $growth_strategy_score = $growth_index * 1;
                $growth_strategy_total = count($this->check_total_questions('growth strategy'));
                $growth_strategy_av = $growth_index / $growth_strategy_total * 100;
                $all_scores[] = array('type' => 'growth strategy',
                    'score' => $growth_strategy_score,
                    'total' => $growth_strategy_total,
                    'average' => $growth_strategy_av);

                // financial management scores
                $financial_management_score = $financial_management_index * 2;
                $financial_management_total = count($this->check_total_questions('financial management'));
                $financial_management_av = $financial_management_index / $financial_management_total * 100;
                $all_scores[] = array('type' => 'financial management',
                    'score' => $financial_management_score,
                    'total' => $financial_management_total,
                    'average' => $financial_management_av);

                // legal scores
                $legal_score = $legal_index * 1;
                $legal_total = count($this->check_total_questions('legal'));
                $legal_av = $legal_index / $legal_total * 100;
                $all_scores[] = array('type' => 'legal',
                    'score' => $legal_score,
                    'total' => $legal_total,
                    'average' => $legal_av);

                // commercial contracts agreements scores
                $commercial_score = $commercial_index * 1;
                $commercial_total = count($this->check_total_questions('commercial contracts agreements'));
                $commercial_av = $commercial_index / $commercial_total * 100;
                $all_scores[] = array('type' => 'commercial contracts agreements',
                    'score' => $commercial_score,
                    'total' => $commercial_total,
                    'average' => $commercial_av);

                // e-commerce scores
                $e_commerce_score = $e_commerce_index * 1;
                $e_commerce_total = count($this->check_total_questions('e-commerce'));
                $e_commerce_av = $e_commerce_index / $e_commerce_total * 100;
                $all_scores[] = array('type' => 'e-commerce',
                    'score' => $e_commerce_score,
                    'total' => $e_commerce_total,
                    'average' => $e_commerce_av);

                return $all_scores;
            }
        }

        public function score_q($user_id){
            $all_responses = $this->all_responses($user_id);
            $question_type = array();
            $biz_phase = $this->check_biz_phase($user_id);
            $all_scores = array();

            // variables
            $value_proposition_index = 0;
            $customer_segments_index = 0;
            $channels_index = 0;
            $customer_relationships_index = 0;
            $revenue_streams_index = 0;
            $key_activities_index = 0;
            $key_resources_index = 0;
            $key_partners_index = 0;
            $cost_structures_index = 0;
            $current_alternatives_index = 0;
            $proof_of_concept_index = 0;
            $unique_selling_point_index = 0;

            $business_process_management_index = 0;
            $marketing_index = 0;
            $employee_index = 0;
            $ownership_and_mindset_index = 0;
            $functional_index = 0;
            $business_and_customers_index = 0;
            $growth_index = 0;
            $delivery_and_expertise_index = 0;
            $compliance_index = 0;
            $market_index = 0;
            $financial_management_index = 0;
            $legal_index = 0;
            $commercial_index = 0;
            $labor_index = 0;
            $regulatory_index = 0;
            $e_commerce_index = 0;

            foreach($all_responses as $v){
                if($v->yes_answer == 1){
                    $question_id = $v->question_id;
                    $question_type[] = $this->check_question_type($question_id);

                }
            }
            foreach($question_type as $v){
                // business concept
                if ($v->sub_category == 'value proposition'){ $value_proposition_index += 1; }
                if ($v->sub_category == 'customer segments'){ $customer_segments_index += 1; }
                if ($v->sub_category == 'channels'){ $channels_index += 1; }
                if ($v->sub_category == 'customer relationships'){ $customer_relationships_index += 1; }
                if ($v->sub_category == 'revenue streams'){ $revenue_streams_index += 1; }
                if ($v->sub_category == 'key activities'){ $key_activities_index += 1; }
                if ($v->sub_category == 'key resources'){ $key_resources_index += 1; }
                if ($v->sub_category == 'key partners'){ $key_partners_index += 1; }
                if ($v->sub_category == 'cost structure'){ $cost_structures_index += 1; }
                if ($v->sub_category == 'current alternatives'){ $current_alternatives_index += 1; }
                if ($v->sub_category == 'proof of concept'){ $proof_of_concept_index += 1; }
                if ($v->sub_category == 'unique selling point'){ $unique_selling_point_index += 1; }

                // business structure
                if ($v->sub_category == 'business process management'){ $business_process_management_index += 1; }
                if ($v->sub_category == 'marketing and sales'){ $marketing_index += 1; }
                if ($v->sub_category == 'employee satisfaction'){ $employee_index += 1; }
                if ($v->sub_category == 'ownership and mindset'){ $ownership_and_mindset_index += 1; }
                if ($v->sub_category == 'functional capability'){ $functional_index += 1; }
                if ($v->sub_category == 'business and customers'){ $business_and_customers_index += 1; }
                if ($v->sub_category == 'growth strategy'){ $growth_index += 1; }
                if ($v->sub_category == 'delivery and expertise'){ $delivery_and_expertise_index += 1; }
                if ($v->sub_category == 'compliance and certification'){ $compliance_index += 1; }
                if ($v->sub_category == 'market intelligence'){ $market_index += 1; }
                if ($v->sub_category == 'financial management'){ $financial_management_index += 1; }
                if ($v->sub_category == 'legal'){ $legal_index += 1; }
                if ($v->sub_category == 'commercial contracts agreements'){ $commercial_index += 1; }
                if ($v->sub_category == 'e-commerce'){ $e_commerce_index += 1; }
            }
            // post revenue scores
            if ($biz_phase->stage === 'pre-revenue' || $biz_phase->stage === 'idea'){
                // value proposition scores
                $value_proposition_score = $value_proposition_index * 3;
                $value_proposition_total = count($this->check_total_questions('value proposition'));
                $value_proposition_av = $value_proposition_index / $value_proposition_total * 100;
                $all_scores[] = array('type' => 'value proposition',
                                    'score' => $value_proposition_score,
                                    'total' => $value_proposition_total,
                                    'average' => $value_proposition_av);

                // customer segments scores
                $customer_segments_score = $customer_segments_index * 3;
                $customer_segments_total = count($this->check_total_questions('customer segments'));
                $customer_segments_av = $customer_segments_index / $customer_segments_total * 100;
                $all_scores[] = array('type' => 'customer segments',
                                    'score' => $customer_segments_score,
                                    'total' => $customer_segments_total,
                                    'average' => $customer_segments_av);

                // channels scores
                $channels_score = $channels_index * 2;
                $channels_total = count($this->check_total_questions('channels'));
                $channels_av = $channels_index / $channels_total * 100;
                $all_scores[] = array('type' => 'channels',
                                    'score' => $channels_score,
                                    'total' => $channels_total,
                                    'average' => $channels_av);

                 // customer relationships scores
                $customer_relationships_score = $customer_relationships_index * 1;
                $customer_relationships_total = count($this->check_total_questions('customer relationships'));
                $customer_relationships_av = $customer_relationships_index / $customer_relationships_total * 100;
                $all_scores[] = array('type' => 'customer relationships',
                                    'score' => $customer_relationships_score,
                                    'total' => $customer_relationships_total,
                                    'average' => $customer_relationships_av);

                // revenue streams scores
                $revenue_streams_score = $revenue_streams_index * 1;
                $revenue_streams_total = count($this->check_total_questions('revenue streams'));
                $revenue_streams_av = $revenue_streams_index / $revenue_streams_total * 100;
                $all_scores[] = array('type' => 'revenue streams',
                                    'score' => $revenue_streams_score,
                                    'total' => $revenue_streams_total,
                                    'average' => $revenue_streams_av);

                // key activities score
                $key_activities_score = $key_activities_index * 2;
                $key_activities_total = count($this->check_total_questions('key activities'));
                $key_activities_av = $key_activities_index / $key_activities_total * 100;
                $all_scores[] = array('type' => 'key activities',
                                    'score' => $key_activities_score,
                                    'total' => $key_activities_total,
                                    'average' => $key_activities_av);

                // key resources scores
                $key_resources_score = $key_resources_index * 1;
                $key_resources_total = count($this->check_total_questions('key resources'));
                $key_resources_av = $key_resources_index / $key_resources_total * 100;
                $all_scores[] = array('type' => 'key resources',
                                    'score' => $key_resources_score,
                                    'total' => $key_resources_total,
                                    'average' => $key_resources_av);

                // key partners scores
                $key_partners_score = $key_partners_index * 1;
                $key_partners_total = count($this->check_total_questions('key partners'));
                $key_partners_av = $key_partners_index / $key_partners_total * 100;
                $all_scores[] = array('type' => 'key partners',
                                    'score' => $key_partners_score,
                                    'total' => $key_partners_total,
                                    'average' => $key_partners_av);

                // cost structure scores
                $cost_structures_score = $cost_structures_index * 1;
                $cost_structures_total = count($this->check_total_questions('cost structure'));
                $cost_structures_av = $cost_structures_index / $cost_structures_total * 100;
                $all_scores[] = array('type' => 'cost structure',
                                    'score' => $cost_structures_score,
                                    'total' => $cost_structures_total,
                                    'average' => $cost_structures_av);

                // current alternatives score
                $current_alternatives_score = $current_alternatives_index * 1;
                $current_alternatives_total = count($this->check_total_questions('current alternatives'));
                $current_alternatives_av = $current_alternatives_index / $current_alternatives_total * 100;
                $all_scores[] = array('type' => 'current alternatives',
                                    'score' => $current_alternatives_score,
                                    'total' => $current_alternatives_total,
                                    'average' => $current_alternatives_av);

                // proof of concept scores
                $proof_of_concept_score = $proof_of_concept_index * 1;
                $proof_of_concept_total = count($this->check_total_questions('proof of concept'));
                $proof_of_concept_av = $proof_of_concept_index / $proof_of_concept_total * 100;
                $all_scores[] = array('type' => 'proof of concept',
                                    'score' => $proof_of_concept_score,
                                    'total' => $proof_of_concept_total,
                                    'average' => $proof_of_concept_av);

                // unique selling point scores
                $unique_selling_point_score =  $unique_selling_point_index * 1;
                $unique_selling_point_total = count($this->check_total_questions('unique selling point'));
                $unique_selling_point_av = $unique_selling_point_index / $unique_selling_point_total * 100;
                $all_scores[] = array('type' => 'unique selling point',
                                    'score' => $unique_selling_point_score,
                                    'total' => $unique_selling_point_total,
                                    'average' => $unique_selling_point_av);

                // business process management scores
                $business_process_management_score =  $business_process_management_index * 3;
                $business_process_management_total = count($this->check_total_questions('business process management'));
                $business_process_management_av = $business_process_management_index / $business_process_management_total * 100;
                $all_scores[] = array('type' => 'business process management',
                                    'score' => $business_process_management_score,
                                    'total' => $business_process_management_total,
                                    'average' => $business_process_management_av);

                // marketing and sales scores
                $marketing_and_sales_score =  $marketing_index * 3;
                $marketing_and_sales_total = count($this->check_total_questions('marketing and sales'));
                $marketing_and_sales_av = $marketing_index / $marketing_and_sales_total * 100;
                $all_scores[] = array('type' => 'marketing and sales',
                    'score' => $marketing_and_sales_score,
                    'total' => $marketing_and_sales_total,
                    'average' => $marketing_and_sales_av);

                // ownership and mindset scores
                $ownership_and_mindset_score =  $ownership_and_mindset_index * 3;
                $ownership_and_mindset_total = count($this->check_total_questions('ownership and mindset'));
                $ownership_and_mindset_av = $ownership_and_mindset_index / $ownership_and_mindset_total * 100;
                $all_scores[] = array('type' => 'ownership and mindset',
                                    'score' => $ownership_and_mindset_score,
                                    'total' => $ownership_and_mindset_total,
                                    'average' => $ownership_and_mindset_av);

                // employee satisfaction scores
                $employee_satisfaction_score =  $employee_index * 3;
                $employee_satisfaction_total = count($this->check_total_questions('employee satisfaction'));
                $employee_satisfaction_av = $employee_index / $employee_satisfaction_total * 100;
                $all_scores[] = array('type' => 'employee satisfaction',
                    'score' => $employee_satisfaction_score,
                    'total' => $employee_satisfaction_total,
                    'average' => $employee_satisfaction_av);

                // functional capability scores
                $functional_capability_score =  $functional_index * 3;
                $functional_capability_total = count($this->check_total_questions('functional capability'));
                $functional_capability_av = $functional_index / $functional_capability_total * 100;
                $all_scores[] = array('type' => 'functional capability',
                    'score' => $functional_capability_score,
                    'total' => $functional_capability_total,
                    'average' => $functional_capability_av);

                // business and customers scores
                $business_and_customers_score =  $business_and_customers_index * 2;
                $business_and_customers_total = count($this->check_total_questions('business and customers'));
                $business_and_customers_av = $business_and_customers_index / $business_and_customers_total * 100;
                $all_scores[] = array('type' => 'business and customers',
                                    'score' => $business_and_customers_score,
                                    'total' => $business_and_customers_total,
                                    'average' => $business_and_customers_av);

                // delivery and expertise scores
                $delivery_and_expertise_score =  $delivery_and_expertise_index * 1;
                $delivery_and_expertise_total = count($this->check_total_questions('delivery and expertise'));
                $delivery_and_expertise_av = $delivery_and_expertise_index / $delivery_and_expertise_total * 100;
                $all_scores[] = array('type' => 'delivery and expertise',
                                    'score' => $delivery_and_expertise_score,
                                    'total' => $delivery_and_expertise_total,
                                    'average' => $delivery_and_expertise_av);

                // compliance and certification scores
                $compliance_and_certification_score =  $compliance_index * 1;
                $compliance_and_certification_total = count($this->check_total_questions('compliance and certification'));
                $compliance_and_certification_av = $compliance_index / $compliance_and_certification_total * 100;
                $all_scores[] = array('type' => 'compliance and certification',
                    'score' => $compliance_and_certification_score,
                    'total' => $compliance_and_certification_total,
                    'average' => $compliance_and_certification_av);

                // market intelligence scores
                $market_intelligence_score =  $market_index * 1;
                $market_intelligence_total = count($this->check_total_questions('market intelligence'));
                $market_intelligence_av = $market_index / $market_intelligence_total * 100;
                $all_scores[] = array('type' => 'market intelligence',
                    'score' => $market_intelligence_score,
                    'total' => $market_intelligence_total,
                    'average' => $market_intelligence_av);

                // growth strategy scores
                $growth_strategy_score =  $growth_index * 1;
                $growth_strategy_total = count($this->check_total_questions('growth strategy'));
                $growth_strategy_av = $growth_index / $growth_strategy_total * 100;
                $all_scores[] = array('type' => 'growth strategy',
                    'score' => $growth_strategy_score,
                    'total' => $growth_strategy_total,
                    'average' => $growth_strategy_av);

                // financial management scores
                $financial_management_score =  $financial_management_index * 2;
                $financial_management_total = count($this->check_total_questions('financial management'));
                $financial_management_av = $financial_management_index / $financial_management_total * 100;
                $all_scores[] = array('type' => 'financial management',
                                    'score' => $financial_management_score,
                                    'total' => $financial_management_total,
                                    'average' => $financial_management_av);

                // legal scores
                $legal_score =  $legal_index * 1;
                $legal_total = count($this->check_total_questions('legal'));
                $legal_av = $legal_index / $legal_total * 100;
                $all_scores[] = array('type' => 'legal',
                                    'score' => $legal_score,
                                    'total' => $legal_total,
                                    'average' => $legal_av);

                // commercial contracts agreements scores
                $commercial_score =  $commercial_index * 1;
                $commercial_total = count($this->check_total_questions('commercial contracts agreements'));
                $commercial_av = $commercial_index / $commercial_total * 100;
                $all_scores[] = array('type' => 'commercial contracts agreements',
                    'score' => $commercial_score,
                    'total' => $commercial_total,
                    'average' => $commercial_av);

                // e-commerce scores
                $e_commerce_score =  $e_commerce_index * 1;
                $e_commerce_total = count($this->check_total_questions('e-commerce'));
                $e_commerce_av = $e_commerce_index / $e_commerce_total * 100;
                $all_scores[] = array('type' => 'e-commerce',
                    'score' => $e_commerce_score,
                    'total' => $e_commerce_total,
                    'average' => $e_commerce_av);
                return $all_scores;

            }

            elseif ($biz_phase->stage == 'post-revenue' || $biz_phase->stage === 'established'){
                // value proposition scores
                $value_proposition_score = $value_proposition_index * 3;
                $value_proposition_total = count($this->check_total_questions('value proposition'));
                $value_proposition_av = $value_proposition_index / $value_proposition_total * 100;
                $all_scores[] = array('type' => 'value proposition',
                                    'score' => $value_proposition_score,
                                    'total' => $value_proposition_total,
                                    'average' => $value_proposition_av);

                // customer segments scores
                $customer_segments_score = $customer_segments_index * 3;
                $customer_segments_total = count($this->check_total_questions('customer segments'));
                $customer_segments_av = $customer_segments_index / $customer_segments_total * 100;
                $all_scores[] = array('type' => 'customer segments',
                                    'score' => $customer_segments_score,
                                    'total' => $customer_segments_total,
                                    'average' => $customer_segments_av);

                // channels scores
                $channels_score = $channels_index * 2;
                $channels_total = count($this->check_total_questions('channels'));
                $channels_av = $channels_index / $channels_total * 100;
                $all_scores[] = array('type' => 'channels',
                                    'score' => $channels_score,
                                    'total' => $channels_total,
                                    'average' => $channels_av);

                 // customer relationships scores
                $customer_relationships_score = $customer_relationships_index * 1;
                $customer_relationships_total = count($this->check_total_questions('customer relationships'));
                $customer_relationships_av = $customer_relationships_index / $customer_relationships_total * 100;
                $all_scores[] = array('type' => 'customer relationships',
                                    'score' => $customer_relationships_score,
                                    'total' => $customer_relationships_total,
                                    'average' => $customer_relationships_av);

                // revenue streams scores
                $revenue_streams_score = $revenue_streams_index * 1;
                $revenue_streams_total = count($this->check_total_questions('revenue streams'));
                $revenue_streams_av = $revenue_streams_index / $revenue_streams_total * 100;
                $all_scores[] = array('type' => 'revenue streams',
                                    'score' => $revenue_streams_score,
                                    'total' => $revenue_streams_total,
                                    'average' => $revenue_streams_av);

                // key activities score
                $key_activities_score = $key_activities_index * 2;
                $key_activities_total = count($this->check_total_questions('key activities'));
                $key_activities_av = $key_activities_index / $key_activities_total * 100;
                $all_scores[] = array('type' => 'key activities',
                                    'score' => $key_activities_score,
                                    'total' => $key_activities_total,
                                    'average' => $key_activities_av);

                // key resources scores
                $key_resources_score = $key_resources_index * 1;
                $key_resources_total = count($this->check_total_questions('key resources'));
                $key_resources_av = $key_resources_index / $key_resources_total * 100;
                $all_scores[] = array('type' => 'key resources',
                                    'score' => $key_resources_score,
                                    'total' => $key_resources_total,
                                    'average' => $key_resources_av);

                // key partners scores
                $key_partners_score = $key_partners_index * 1;
                $key_partners_total = count($this->check_total_questions('key partners'));
                $key_partners_av = $key_partners_index / $key_partners_total * 100;
                $all_scores[] = array('type' => 'key partners',
                                    'score' => $key_partners_score,
                                    'total' => $key_partners_total,
                                    'average' => $key_partners_av);

                // cost structure scores
                $cost_structures_score = $cost_structures_index * 1;
                $cost_structures_total = count($this->check_total_questions('cost structure'));
                $cost_structures_av = $cost_structures_index / $cost_structures_total * 100;
                $all_scores[] = array('type' => 'cost structure',
                                    'score' => $cost_structures_score,
                                    'total' => $cost_structures_total,
                                    'average' => $cost_structures_av);

                // current alternatives score
                $current_alternatives_score = $current_alternatives_index * 1;
                $current_alternatives_total = count($this->check_total_questions('current alternatives'));
                $current_alternatives_av = $current_alternatives_index / $current_alternatives_total * 100;
                $all_scores[] = array('type' => 'current alternatives',
                                    'score' => $current_alternatives_score,
                                    'total' => $current_alternatives_total,
                                    'average' => $current_alternatives_av);

                // proof of concept scores
                $proof_of_concept_score = $proof_of_concept_index * 1;
                $proof_of_concept_total = count($this->check_total_questions('proof of concept'));
                $proof_of_concept_av = $proof_of_concept_index / $proof_of_concept_total * 100;
                $all_scores[] = array('type' => 'proof of concept',
                                    'score' => $current_alternatives_score,
                                    'total' => $current_alternatives_total,
                                    'average' => $current_alternatives_av);

                // unique selling point scores
                $unique_selling_point_score =  $unique_selling_point_index * 1;
                $unique_selling_point_total = count($this->check_total_questions('unique selling point'));
                $unique_selling_point_av = $unique_selling_point_index / $unique_selling_point_total * 100;
                $all_scores[] = array('type' => 'unique selling point',
                                    'score' => $unique_selling_point_score,
                                    'total' => $unique_selling_point_total,
                                    'average' => $unique_selling_point_av);

                // business process management scores
                $business_process_management_score =  $business_process_management_index * 3;
                $business_process_management_total = count($this->check_total_questions('business process management'));
                $business_process_management_av = $business_process_management_index / $business_process_management_total * 100;
                $all_scores[] = array('type' => 'business process management',
                    'score' => $business_process_management_score,
                    'total' => $business_process_management_total,
                    'average' => $business_process_management_av);

                // marketing and sales scores
                $marketing_and_sales_score =  $marketing_index * 3;
                $marketing_and_sales_total = count($this->check_total_questions('marketing and sales'));
                $marketing_and_sales_av = $marketing_index / $marketing_and_sales_total * 100;
                $all_scores[] = array('type' => 'marketing and sales',
                    'score' => $marketing_and_sales_score,
                    'total' => $marketing_and_sales_total,
                    'average' => $marketing_and_sales_av);

                // ownership and mindset scores
                $ownership_and_mindset_score =  $ownership_and_mindset_index * 3;
                $ownership_and_mindset_total = count($this->check_total_questions('ownership and mindset'));
                $ownership_and_mindset_av = $ownership_and_mindset_index / $ownership_and_mindset_total * 100;
                $all_scores[] = array('type' => 'ownership and mindset',
                    'score' => $ownership_and_mindset_score,
                    'total' => $ownership_and_mindset_total,
                    'average' => $ownership_and_mindset_av);

                // employee satisfaction scores
                $employee_satisfaction_score =  $employee_index * 3;
                $employee_satisfaction_total = count($this->check_total_questions('employee satisfaction'));
                $employee_satisfaction_av = $employee_index / $employee_satisfaction_total * 100;
                $all_scores[] = array('type' => 'employee satisfaction',
                    'score' => $employee_satisfaction_score,
                    'total' => $employee_satisfaction_total,
                    'average' => $employee_satisfaction_av);

                // functional capability scores
                $functional_capability_score =  $functional_index * 3;
                $functional_capability_total = count($this->check_total_questions('functional capability'));
                $functional_capability_av = $functional_index / $functional_capability_total * 100;
                $all_scores[] = array('type' => 'functional capability',
                    'score' => $functional_capability_score,
                    'total' => $functional_capability_total,
                    'average' => $functional_capability_av);

                // business and customers scores
                $business_and_customers_score =  $business_and_customers_index * 2;
                $business_and_customers_total = count($this->check_total_questions('business and customers'));
                $business_and_customers_av = $business_and_customers_index / $business_and_customers_total * 100;
                $all_scores[] = array('type' => 'business and customers',
                    'score' => $business_and_customers_score,
                    'total' => $business_and_customers_total,
                    'average' => $business_and_customers_av);

                // delivery and expertise scores
                $delivery_and_expertise_score =  $delivery_and_expertise_index * 1;
                $delivery_and_expertise_total = count($this->check_total_questions('delivery and expertise'));
                $delivery_and_expertise_av = $delivery_and_expertise_index / $delivery_and_expertise_total * 100;
                $all_scores[] = array('type' => 'delivery and expertise',
                    'score' => $delivery_and_expertise_score,
                    'total' => $delivery_and_expertise_total,
                    'average' => $delivery_and_expertise_av);

                // compliance and certification scores
                $compliance_and_certification_score =  $compliance_index * 1;
                $compliance_and_certification_total = count($this->check_total_questions('compliance and certification'));
                $compliance_and_certification_av = $compliance_index / $compliance_and_certification_total * 100;
                $all_scores[] = array('type' => 'compliance and certification',
                    'score' => $compliance_and_certification_score,
                    'total' => $compliance_and_certification_total,
                    'average' => $compliance_and_certification_av);

                // market intelligence scores
                $market_intelligence_score =  $market_index * 1;
                $market_intelligence_total = count($this->check_total_questions('market intelligence'));
                $market_intelligence_av = $market_index / $market_intelligence_total * 100;
                $all_scores[] = array('type' => 'market intelligence',
                    'score' => $market_intelligence_score,
                    'total' => $market_intelligence_total,
                    'average' => $market_intelligence_av);

                // growth strategy scores
                $growth_strategy_score =  $growth_index * 1;
                $growth_strategy_total = count($this->check_total_questions('growth strategy'));
                $growth_strategy_av = $growth_index / $growth_strategy_total * 100;
                $all_scores[] = array('type' => 'growth strategy',
                    'score' => $growth_strategy_score,
                    'total' => $growth_strategy_total,
                    'average' => $growth_strategy_av);

                // financial management scores
                $financial_management_score =  $financial_management_index * 2;
                $financial_management_total = count($this->check_total_questions('financial management'));
                $financial_management_av = $financial_management_index / $financial_management_total * 100;
                $all_scores[] = array('type' => 'financial management',
                    'score' => $financial_management_score,
                    'total' => $financial_management_total,
                    'average' => $financial_management_av);

                // legal scores
                $legal_score =  $legal_index * 1;
                $legal_total = count($this->check_total_questions('legal'));
                $legal_av = $legal_index / $legal_total * 100;
                $all_scores[] = array('type' => 'legal',
                    'score' => $legal_score,
                    'total' => $legal_total,
                    'average' => $legal_av);

                // commercial contracts agreements scores
                $commercial_score =  $commercial_index * 1;
                $commercial_total = count($this->check_total_questions('commercial contracts agreements'));
                $commercial_av = $commercial_index / $commercial_total * 100;
                $all_scores[] = array('type' => 'commercial contracts agreements',
                    'score' => $commercial_score,
                    'total' => $commercial_total,
                    'average' => $commercial_av);

                // e-commerce scores
                $e_commerce_score =  $e_commerce_index * 1;
                $e_commerce_total = count($this->check_total_questions('e-commerce'));
                $e_commerce_av = $e_commerce_index / $e_commerce_total * 100;
                $all_scores[] = array('type' => 'e-commerce',
                    'score' => $e_commerce_score,
                    'total' => $e_commerce_total,
                    'average' => $e_commerce_av);

                return $all_scores;
            }

        }

        public function all_quesion_ids_by_cat($cat){
            global $db;
            $query = "SELECT question_id FROM questions WHERE sub_category = '".strtolower($cat)."'";
            $result = $db->query($query);
            while($obj = $result->fetch_object()){
                $results[] = $obj;
            }
            return $results;
        }

        public function highest_top3($user_id, $category){
            $all_scores = array();
            if ($category == 'structure'){
                $all_scores = $this->structure_scores($user_id);
            }
            if ($category == 'concept'){
                $all_scores = $this->concept_scores($user_id);
            }
            $average_scores = array();
            foreach ($all_scores as $val){
                $average_scores[] = array ('type' => $val['type'], 'average' => $val['average']);
            }
            foreach($average_scores as $v){
                $sorted[] = $v['average'];
            }
            array_multisort($sorted, SORT_DESC, $average_scores);
            return $average_scores;
        }

        public function lowest_top3($user_id, $category){
            if ($category == 'structure'){
                $all_scores = $this->structure_scores($user_id);
            }
            if ($category == 'concept'){
                $all_scores = $this->concept_scores($user_id);
            }
            $average_scores = array();
            foreach ($all_scores as $val){
                $average_scores[] = array ('type' => $val['type'], 'average' => $val['average']);
            }
            foreach($average_scores as $v){
                $sorted[] = $v['average'];
            }
            array_multisort($sorted, SORT_ASC, $average_scores);
            return $average_scores;
        }

        private function check_q_response($sub_category){
            global $db;
            $results = array();

            $query = "SELECT question_id, negative, positive FROM questions WHERE sub_category = '$sub_category'";
            $result = $db->query($query);
            while($obj = $result->fetch_object()){
                $results[] = $obj;
            }
            return $results;
        }

        private function load_negative_responses($user_id, $question_id){
            global $db;
            $results = array();
            $query = "SELECT * FROM q_answers WHERE question_id = '$question_id' AND no_answer = 1 AND user_id = '$user_id'";
            $result = $db->query($query);
            while($obj = $result->fetch_object()){
                $results[] = $obj;
            }
            return $results;
        }

        private function load_positive_response($user_id, $question_id){
            global $db;
            $results = array();
            $query = "SELECT * FROM q_answers WHERE question_id = '$question_id' AND yes_answer = 1 AND user_id = '$user_id'";
            $result = $db->query($query);
            while($obj = $result->fetch_object()){
                $results[] = $obj;
            }
            return $results;
        }

        public function display_high_top3($user_id, $category){
            global $db;
            $average_scores_s = $this->highest_top3($user_id, $category);
            $top3 = array_slice($average_scores_s, 0, 3);
            foreach($top3 as $val){
                $type = $val['type'];
                $score = round($val['average']);
                $key = uniqid();
                $slug = str_replace(' ', '-',$type);
                $total_q = 0;
                $q_answered = 0;
                $incomp = '';
                $questions = $this->all_quesion_ids_by_cat($type);
                $total_q += count($questions);
                foreach($questions as $q){
                    $query = "SELECT * FROM q_answers WHERE question_id='".$q->question_id."' AND user_id='$user_id'";
                    if($db->query($query)->num_rows > 0){
                        $q_answered++;
                    }
                }
                if ($q_answered < $total_q) {
                    $incomp = 'bg-danger p-2 text-white my-2';
                }
                if (!empty($incomp)) {
                    echo "<div class='$incomp'>";
                    echo '<p class="font-weight-bold">'.$type.': '.$score.'%</p>';
                    echo "<p>$q_answered / $total_q Questions answered</p>";
                    $choice = $this->find_key($type);
                    echo '<a href="entrepreneur-summary.php?choice='.$choice.'" class="btn btn-primary btn-sm">Complete Assessment</a>';
                }else{
                    echo '<p class="font-weight-bold">'.$type.': '.$score.'%</p>';
                }
                // // load  question ids
                $sub_category = $val['type'];
                $question_ids = $this->check_q_response($sub_category);
                // // load responses
                echo '<ul class="list-group" >';
                foreach ($question_ids as $val2){
                    $question_id = $val2->question_id;
                    if (!empty($this->load_negative_responses($user_id, $question_id))){
                        echo '<li class="text-danger list-group-item">'.$val2->negative.'</li>';
                    }
                    if (!empty($this->load_positive_response($user_id, $question_id))){
                        echo '<li class="text-success list-group-item">'.$val2->positive.'</li>';
                    }
                }
                echo '</ul>';
                if (!empty($incomp)) {
                    echo '</div>';
                }
            }
        }

        public function display_low_top3($user_id, $category){
            global $db;
            $average_scores_s = $this->lowest_top3($user_id, $category);
            $top3 = array_slice($average_scores_s, 0, 3);
            $key = uniqid();
            foreach($top3 as $val){
                $type = $val['type'];
                $score = round($val['average']);
                $slug = str_replace(' ', '-',$type);
                $total_q = 0;
                $incomp = '';
                $q_answered = 0;
                $questions = $this->all_quesion_ids_by_cat($type);
                $total_q += count($questions);
                foreach($questions as $q){
                    $query = "SELECT * FROM q_answers WHERE question_id='".$q->question_id."' AND user_id='$user_id'";
                    if($db->query($query)->num_rows > 0){
                        $q_answered++;
                    }
                }
                if ($q_answered < $total_q) {
                    $incomp = 'bg-danger p-2 text-white my-2';
                }
                if (!empty($incomp)) {
                    echo "<div class='$incomp'>";
                    echo '<p class="font-weight-bold">'.$type.': '.$score.'%</p>';
                    echo "<p>$q_answered / $total_q Questions answered</p>";
                    $choice = $this->find_key($type);
                    echo '<a href="entrepreneur-summary.php?choice='.$choice.'" class="btn btn-primary btn-sm">Complete Assessment</a>';
                }else{
                    echo '<p class="font-weight-bold">'.$type.': '.$score.'%</p>';
                }
                // // load  question ids
                $sub_category = $val['type'];
                $question_ids = $this->check_q_response($sub_category);
                // // load responses
                echo '<ul class="list-group" >';
                foreach ($question_ids as $val2){
                    $question_id = $val2->question_id;
                    if (!empty($this->load_negative_responses($user_id, $question_id))){
                        echo '<li class="text-danger list-group-item">'.$val2->negative.'</li>';
                    }
                    if (!empty($this->load_positive_response($user_id, $question_id))){
                        echo '<li class="text-success list-group-item">'.$val2->positive.'</li>';
                    }
                }
                echo '</ul>';
                if (!empty($incomp)) {
                    echo '</div>';
                }
            }
        }

        public function display_all($user_id, $category){
            global $db;
            $average_scores_s = $this->lowest_top3($user_id, $category);
            // $top3 = array_slice($average_scores_s, 0, 3);
            $key = uniqid();
            foreach($average_scores_s as $val){
                $type = $val['type'];
                $score = round($val['average']);
                $slug = str_replace(' ', '-',$type);
                $total_q = 0;
                $incomp = '';
                $q_answered = 0;
                $questions = $this->all_quesion_ids_by_cat($type);
                $total_q += count($questions);
                foreach($questions as $q){
                    $query = "SELECT * FROM q_answers WHERE question_id='".$q->question_id."' AND user_id='$user_id'";
                    if($db->query($query)->num_rows > 0){
                        $q_answered++;
                    }
                }
                if ($q_answered < $total_q) {
                    $incomp = 'bg-danger p-2 text-white my-2';
                }
                if (!empty($incomp)) {
                    echo "<div class='$incomp'>";
                    echo '<p class="font-weight-bold">'.$type.': '.$score.'%</p>';
                    echo "<p>$q_answered / $total_q Questions answered</p>";
                    $choice = $this->find_key($type);
                    echo '<a href="entrepreneur-summary.php?choice='.$choice.'" class="btn btn-primary btn-sm">Complete Assessment</a>';
                }else{
                    echo '<p class="font-weight-bold">'.$type.': '.$score.'%</p>';
                }
                // // load  question ids
                $sub_category = $val['type'];
                $question_ids = $this->check_q_response($sub_category);
                // // load responses
                echo '<ul class="list-group" >';
                foreach ($question_ids as $val2){
                    $question_id = $val2->question_id;
                    if (!empty($this->load_negative_responses($user_id, $question_id))){
                        echo '<li class="text-danger list-group-item">'.$val2->negative.'</li>';
                    }
                    if (!empty($this->load_positive_response($user_id, $question_id))){
                        echo '<li class="text-success list-group-item">'.$val2->positive.'</li>';
                    }
                }
                echo '</ul>';
                if (!empty($incomp)) {
                    echo '</div>';
                }
            }
        }

        public function find_key($value)
        {
            global $questions_seq;
            foreach($questions_seq as $key => $categories){
                foreach($categories as $category){
                    if ( strtolower($category) == strtolower($value) ){
                        return $key;
                    }
                }
           }
           return false;
        }

        public function display_others($user_id, $others){
            global $db;
            foreach($others as $val){
                $key = uniqid();
                $type = $val['type'];
                $score = round($val['average']);
                $slug = str_replace(' ', '-',$type);
                $total_q = 0;
                $incomp = '';
                $q_answered = 0;
                $questions = $this->all_quesion_ids_by_cat($type);
                $total_q += count($questions);
                foreach($questions as $q){
                    $query = "SELECT * FROM q_answers WHERE question_id='".$q->question_id."' AND user_id='$user_id'";
                    if($db->query($query)->num_rows > 0){
                        $q_answered++;
                    }
                }
                if ($q_answered < $total_q) {
                    $incomp = 'bg-danger p-2 text-white my-2';
                }
                if (!empty($incomp)) {
                    echo "<div class='$incomp'>";
                    echo '<p class="font-weight-bold">'.$type.': '.$score.'%</p>';
                    echo "<p>$q_answered / $total_q Questions answered</p>";
                    $choice = $this->find_key($type);
                    echo '<a href="entrepreneur-summary.php?choice='.$choice.'" class="btn btn-primary btn-sm">Complete Assessment</a>';
                }else{
                    echo '<p class="font-weight-bold">'.$type.': '.$score.'%</p>';
                }
                // // load  question ids
                $sub_category = $val['type'];
                $question_ids = $this->check_q_response($sub_category);
                // // load responses
                echo '<ul class="list-group" >';
                foreach ($question_ids as $val2){
                    $question_id = $val2->question_id;
                    if (!empty($this->load_negative_responses($user_id, $question_id))){
                        echo '<li class="text-danger list-group-item">'.$val2->negative.'</li>';
                    }
                    if (!empty($this->load_positive_response($user_id, $question_id))){
                        echo '<li class="text-success list-group-item">'.$val2->positive.'</li>';
                    }
                }
                echo '</ul>';
                if (!empty($incomp)) {
                    echo '</div>';
                }
            }
        }

        private function num_question($sub_category){
            global $db;

            $query = "SELECT * FROM questions WHERE sub_category = '$sub_category'";
            $result = $db->query($query);
            while($obj = $result->fetch_object()){
                $results[] = $obj;
            }
            return count($results);
        }

        public function num_value_questions(){
            $sub_category = 'value proposition';
            $num = $this->num_question($sub_category);
            return $num;
        }
        public function num_sec_questions($sub_category){
            $num = $this->num_question($sub_category);
            return $num;
        }

        public function num_segment_question(){
            $sub_category = 'customer segments';
            $num = $this->num_question($sub_category);
            return $num;
        }

        public function num_concept_question(){
            $sub_category = 'proof of concept';
            $num = $this->num_question($sub_category);
            return $num;
        }

        public function num_question_negative($user_id, $sub_category){
            $question_ids = $this->check_q_response($sub_category);
            $index = 0;
            // load responses
            foreach ($question_ids as $val2){
                $question_id = $val2->question_id;
                if (!empty($this->load_negative_responses($user_id, $question_id))){
                    $index += 1;
                }
            }
            return $index;
        }

        public function display_q_negative($user_id, $sub_category){
            $question_ids = $this->check_q_response($sub_category);
            $slug = str_replace(' ', '-',$sub_category);
            // load responses
            echo '<ul class="list-group">';
            foreach ($question_ids as $val2){
                $question_id = $val2->question_id;
                if (!empty($this->load_negative_responses($user_id, $question_id))){
                    echo '<li class="text-danger list-group-item">'.$val2->negative.'</li>';
                }
            }
            echo '</ul>';
        }

        public function display_q_positive($user_id, $sub_category){
            $question_ids = $this->check_q_response($sub_category);
            $slug = str_replace(' ', '-',$sub_category);
            // load responses
            echo '<ul class="list-group">';
            foreach ($question_ids as $val2){
                $question_id = $val2->question_id;
                if (!empty($this->load_positive_response($user_id, $question_id))){
                    echo '<li class="text-success list-group-item">'.$val2->positive.'</li>';
                }
            }
            echo '</ul>';
        }
    }
?>
